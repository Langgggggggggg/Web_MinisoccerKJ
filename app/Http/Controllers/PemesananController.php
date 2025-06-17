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
            // 'dp' => 'required|numeric|min:100000',
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
                'status' => $status,
            ]);

            // Kirim notifikasi WhatsApp untuk detail pemesanan baru
            NotifikasiHelper::kirimNotifikasiDetailPemesanan($pemesanan);
            // Kirim notifikasi pengingat pembayaran
            NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan);

            DB::commit();
            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
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
            // 'dp' => 'required|numeric|min:100000',
            'dp' => 'required|numeric|min:20000',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
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
                return back()->withErrors(['error' => 'Tidak ada jadwal yang valid.']);
            }

            $dp_total = $request->dp;
            $dp_per_jadwal = $dp_total / $jumlah_jadwal_valid;

            foreach ($request->jam_mulai as $index => $mulai) {
                $selesai = $request->jam_selesai[$index];
                $tanggal = $request->tanggal[$index];

                if (!$mulai || !$selesai || !$tanggal) continue;

                if (strtotime($selesai) <= strtotime($mulai)) {
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
                $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';

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
                    'status' => $status,
                ]);

                // Kirim notifikasi pengingat pembayaran
                NotifikasiHelper::kirimNotifikasiPembayaran($pemesanan);
                $lastTanggal = $tanggal;
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
            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan member berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
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
        // \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => strtoupper(substr(uniqid(), -5)), // Buat order ID unik
                'gross_amount' => (int) $request->dp, // Gunakan nilai DP sebagai gross_amount
            ],
            'customer_details' => [
                'first_name' => $request->nama_tim,
                'phone' => $request->no_telepon,
            ],
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
}
