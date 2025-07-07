<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Member;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\NotifikasiHelper;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function index()
    {
        // Mengambil pemesanan hanya untuk user yang sedang login
        $pemesanan = Pemesanan::where('user_id', Auth::id())->get();


        // Mengelompokkan pemesanan berdasarkan kode pemesanan
        $groupedPemesanan = $pemesanan->groupBy('kode_pemesanan');

        return view('pemesanan.detail', compact('groupedPemesanan'));
    }
    public function create()
    {
        $jadwals = Pemesanan::orderBy('tanggal')->orderBy('jam_mulai')->get();
        return view('pemesanan.create', compact('jadwals'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan' => 'required|integer|in:1,2,3,4,5',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'dp' => 'required|numeric|min:10000',
        ]);

        $kode_pemesanan = strtoupper(substr(uniqid(), -5));
        $durasi = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
        $total_harga = 0;
        $jam_mulai = strtotime($request->jam_mulai);

        for ($i = 0; $i < $durasi; $i++) {
            $current_time = strtotime("+$i hour", $jam_mulai);
            $current_hour = date('H:i', $current_time);

            if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 300000 : 350000;
            } elseif ($request->lapangan >= 4 && $request->lapangan <= 5) {
                $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 400000 : 450000;
            } else {
                $harga_per_jam = 0;
            }

            $total_harga += $harga_per_jam;
        }

        $dp = $request->dp;
        $sisa_bayar = max(0, $total_harga - $dp);
        $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';

        DB::beginTransaction();
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $pemesanan = Pemesanan::create([
                'user_id' => $user->id,
                'kode_pemesanan' => $kode_pemesanan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'lapangan' => $request->lapangan,
                'nama_tim' => $request->nama_tim,
                'no_telepon' => $request->no_telepon,
                'dp' => $dp,
                'harga' => $total_harga,
                'sisa_bayar' => $sisa_bayar,
                'status' => 'pending',
            ]);


            // NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan);

            DB::commit();

            // Jika AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'kode_pemesanan' => $pemesanan->kode_pemesanan,
                    'dp' => $dp,
                    'nama_tim' => $pemesanan->nama_tim,
                    'no_telepon' => $pemesanan->no_telepon,
                    'lapangan' => $pemesanan->lapangan,
                    'tanggal' => $pemesanan->tanggal,
                    'jam_mulai' => $pemesanan->jam_mulai,
                    'jam_selesai' => $pemesanan->jam_selesai,
                ]);
            }

            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    public function storeMember(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            'lapangan' => 'required|integer|in:1,2,3,4,5',
            'jam_mulai' => 'required|array',
            'jam_selesai' => 'required|array',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'dp' => 'required|numeric|min:20000',
        ]);

        $user = Auth::user();
        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
            return back()->withErrors(['error' => 'User not authenticated']);
        }

        DB::beginTransaction();
        try {
            $lastTanggal = null;
            $jumlah_jadwal_valid = 0;

            // Hitung jumlah jadwal valid
            foreach ($request->jam_mulai as $index => $mulai) {
                if ($mulai && $request->jam_selesai[$index] && $request->tanggal[$index]) {
                    $jumlah_jadwal_valid++;
                }
            }

            if ($jumlah_jadwal_valid == 0) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Tidak ada jadwal yang valid.'], 422);
                }
                return back()->withErrors(['error' => 'Tidak ada jadwal yang valid.']);
            }

            $dp_total = $request->dp;
            $dp_per_jadwal = $dp_total / $jumlah_jadwal_valid;
            $createdPemesanan = [];

            foreach ($request->jam_mulai as $index => $mulai) {
                $selesai = $request->jam_selesai[$index];
                $tanggal = $request->tanggal[$index];

                if (!$mulai || !$selesai || !$tanggal) continue;

                if (strtotime($selesai) <= strtotime($mulai)) {
                    if ($request->ajax()) {
                        return response()->json(['error' => 'Jam selesai harus lebih besar dari jam mulai di jadwal ke-' . ($index + 1)], 422);
                    }
                    return back()->withErrors(['error' => 'Jam selesai harus lebih besar dari jam mulai di jadwal ke-' . ($index + 1)]);
                }

                $durasi = (strtotime($selesai) - strtotime($mulai)) / 3600;
                $total_harga = 0;
                $jam_mulai_ts = strtotime($mulai);

                for ($i = 0; $i < $durasi; $i++) {
                    $current_time = strtotime("+$i hour", $jam_mulai_ts);
                    $current_hour = date('H:i', $current_time);

                    if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                        $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 300000 : 350000;
                    } elseif ($request->lapangan >= 4 && $request->lapangan <= 5) {
                        $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 400000 : 450000;
                    } else {
                        $harga_per_jam = 0;
                    }

                    $total_harga += $harga_per_jam;
                }

                $kode_pemesanan = 'MBR-' . strtoupper(substr(uniqid(), -5));
                $dp = $dp_per_jadwal;
                $total_diskon = 25000 * $durasi;
                $sisa_bayar = max(0, $total_harga - $dp - $total_diskon);

                $pemesanan = Pemesanan::create([
                    'user_id' => $user->id,
                    'kode_pemesanan' => $kode_pemesanan,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $mulai,
                    'jam_selesai' => $selesai,
                    'lapangan' => $request->lapangan,
                    'nama_tim' => $request->nama_tim,
                    'no_telepon' => $request->no_telepon,
                    'dp' => $dp,
                    'harga' => $total_harga,
                    'sisa_bayar' => $sisa_bayar,
                    'status' => 'belum lunas',
                ]);

                // NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan);
                $lastTanggal = $tanggal;
                $createdPemesanan[] = $pemesanan;
            }

            // Tambahkan status member
            if ($lastTanggal) {
                Member::create([
                    'user_id' => $user->id,
                    'status' => 'aktif',
                    'tanggal_berakhir' => date('Y-m-d', strtotime($lastTanggal)),
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                // Return data pemesanan pertama untuk kebutuhan Snap
                $first = $createdPemesanan[0] ?? null;
                return response()->json([
                    'success' => true,
                    'kode_pemesanan' => $first ? $first->kode_pemesanan : null,
                    'dp' => $dp_total, // <-- DP total, bukan per jadwal!
                    'nama_tim' => $first ? $first->nama_tim : null,
                    'no_telepon' => $first ? $first->no_telepon : null,
                    'lapangan' => $first ? $first->lapangan : null,
                    'tanggal' => $first ? $first->tanggal : null,
                    'jam_mulai' => $first ? $first->jam_mulai : null,
                    'jam_selesai' => $first ? $first->jam_selesai : null,
                ]);
            }

            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan member berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Method edit
    public function edit($kode_pemesanan)
    {
        $pemesanan = Pemesanan::where('kode_pemesanan', $kode_pemesanan)->firstOrFail();
        $jadwals = Pemesanan::orderBy('tanggal')->orderBy('jam_mulai')->get();

        return view('pemesanan.edit', compact('pemesanan', 'jadwals'));
    }

    // Method update
    public function update(Request $request, $kode_pemesanan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan' => 'required|integer|in:1,2,3,4,5',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        $pemesanan = Pemesanan::where('kode_pemesanan', $kode_pemesanan)->first();

        if (!$pemesanan) {
            return back()->with(['error' => 'Pemesanan tidak ditemukan.']);
        }

        // Tidak boleh ubah jika sudah <1 hari dari tanggal main
        $tanggalSekarang = Carbon::now();
        $tanggalPemesanan = Carbon::parse($pemesanan->tanggal);
        $batasUbah = $tanggalPemesanan->subDay();

        if ($tanggalSekarang->greaterThan($batasUbah)) {
            return back()->with('error', 'Anda tidak dapat mengubah pemesanan kurang dari 1 hari sebelum bermain.');
        }

        $dpLama = $pemesanan->dp;

        // Hitung ulang harga berdasarkan jam & lapangan baru
        $durasi = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
        $total_harga = 0;
        $jam_mulai = strtotime($request->jam_mulai);

        for ($i = 0; $i < $durasi; $i++) {
            $current_time = strtotime("+$i hour", $jam_mulai);
            $current_hour = date('H:i', $current_time);

            if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 300000 : 350000;
            } elseif ($request->lapangan >= 4 && $request->lapangan <= 5) {
                $harga_per_jam = ($current_hour >= '07:00' && $current_hour < '17:00') ? 400000 : 450000;
            } else {
                $harga_per_jam = 0;
            }

            $total_harga += $harga_per_jam;
        }

        $sisa_bayar = max(0, $total_harga - $dpLama);
        $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';

        DB::beginTransaction();
        try {
            $pemesanan->update([
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'lapangan' => $request->lapangan,
                'nama_tim' => $request->nama_tim,
                'no_telepon' => $request->no_telepon,
                'harga' => $total_harga,
                'sisa_bayar' => $sisa_bayar,
                'status' => $status,
            ]);

            NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan, true); // kirim notifikasi update
            DB::commit();

            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat update: ' . $e->getMessage());
        }
    }
    public function validateSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan' => 'required|integer',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $tanggal = $request->tanggal;
        $lapangan = $request->lapangan;
        $jamMulaiBaru = $request->jam_mulai;
        $jamSelesaiBaru = $request->jam_selesai;

        //  Cek jika hari adalah Senin
        $hari = Carbon::parse($tanggal)->format('l'); // e.g., 'Monday'
        if ($hari === 'Monday') {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal yang dipilih tidak tersedia karena pada hari Senin Minisoccer KJ libur.',
            ]);
        }

        // ✔️ Cek tumpang tindih jadwal
        $konflik = Pemesanan::where('tanggal', $tanggal)
            ->where('lapangan', $lapangan)
            ->where(function ($query) use ($jamMulaiBaru, $jamSelesaiBaru) {
                $query->where(function ($q) use ($jamMulaiBaru, $jamSelesaiBaru) {
                    $q->where('jam_mulai', '<', $jamSelesaiBaru)
                        ->where('jam_selesai', '>', $jamMulaiBaru);
                });
            })
            ->exists();

        if ($konflik) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal yang anda pilih sudah dipesan, silahkan pilih jadwal lain',
            ]);
        }

        return response()->json(['success' => true]);
    }
    public function getSnapToken(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = $request->order_id; // kode_pemesanan dari database

        $itemDetails = [
            [
                'id' => $orderId,
                'price' => (int) $request->dp,
                'quantity' => 1,
                'name' => 'DP Sewa Lapangan ' . ($request->lapangan ?? ''),

                'brand' => 'Minisoccer KJ',
                'category' => 'Sewa Lapangan',
                'merchant_name' => 'Minisoccer KJ',
                'description' => 'DP sewa lapangan nomor ' . ($request->lapangan ?? '') .
                    ' tanggal ' . ($request->tanggal ?? '') .
                    ' jam ' . ($request->jam_mulai ?? '') . '-' . ($request->jam_selesai ?? ''),

            ]
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->dp,
            ],
            'customer_details' => [
                'first_name' => $request->nama_tim,
                'phone' => $request->no_telepon,
            ],
            'item_details' => $itemDetails,
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response()->json(['snapToken' => $snapToken]);
    }

    public function getBookedSchedules(Request $request)
    {
        $tanggal = $request->tanggal;
        $lapangan = $request->lapangan;

        $bookedSchedules = Pemesanan::where('tanggal', $tanggal)
            ->where('lapangan', $lapangan)
            ->get(['kode_pemesanan', 'tanggal', 'jam_mulai', 'jam_selesai'])
            ->map(function ($item) {
                return [
                    'start' => $item->jam_mulai,
                    'end' => $item->jam_selesai
                ];
            });

        return response()->json($bookedSchedules);
    }
    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $pemesanan = Pemesanan::where('kode_pemesanan', $request->order_id)->first();
            if ($pemesanan) {
                if (
                    $request->transaction_status == 'capture' ||
                    $request->transaction_status == 'settlement'
                ) {
                    // Pembayaran sukses, cek sisa bayar
                    $pemesanan->status = ($pemesanan->sisa_bayar <= 0) ? 'lunas' : 'belum lunas';

                    // Cek apakah pesanan ini adalah pesanan member
                    if (str_starts_with($pemesanan->kode_pemesanan, 'MBR-')) {
                        // Kirim notifikasi detail member
                        $pemesananList = Pemesanan::where('user_id', $pemesanan->user_id)
                            ->where('kode_pemesanan', 'LIKE', 'MBR-%')
                            ->get();

                        // Kirim notifikasi sisa bayar untuk semua pesanan member
                        foreach ($pemesananList as $pesananMember) {
                            NotifikasiHelper::kirimNotifikasiPembayaran($pesananMember);
                        }

                        // Kirim notifikasi detail member
                        NotifikasiHelper::kirimNotifikasiDetailMember($pemesananList->toArray());
                    } else {
                        // Kirim notifikasi detail pemesanan biasa
                        NotifikasiHelper::kirimNotifikasiDetailPemesanan($pemesanan);

                        // Kirim notifikasi sisa bayar untuk pesanan biasa
                        NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan);
                    }
                } elseif ($request->transaction_status == 'pending') {
                    // User baru memilih metode pembayaran, status tetap pending
                    $pemesanan->status = 'pending';
                }
                $pemesanan->save();
            }
        }
        return response()->json(['message' => 'OK']);
    }
}
