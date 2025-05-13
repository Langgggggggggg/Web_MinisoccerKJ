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
        $pemesanan = Pemesanan::where('user_id', Auth::id())
            ->with('jadwal')  // Memastikan jadwal ikut dimuat
            ->get();

        // Mengelompokkan pemesanan berdasarkan kode pemesanan
        $groupedPemesanan = $pemesanan->groupBy('kode_pemesanan');

        return view('pemesanan.detail', compact('groupedPemesanan'));
    }
    public function create()
    {
        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam')->get();
        return view('pemesanan.create', compact('jadwals'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'tanggal' => 'required|date',
                'lapangan' => 'required|string',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required|after:jam_mulai',
                'nama_tim' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:15',
                'dp' => 'required|numeric|min:100000',
            ],
        );

        // Cari ID Jadwal berdasarkan tanggal, lapangan, dan jam yang dipilih
        $jadwals = Jadwal::where('tanggal', $request->tanggal)
            ->where('lapangan', $request->lapangan)
            ->where('jam', '>=', $request->jam_mulai)
            ->where('jam', '<', $request->jam_selesai) // Hanya hingga sebelum jam selesai
            ->get();

        $kode_pemesanan = strtoupper(substr(uniqid(), -5));

        DB::beginTransaction();
        try {
            foreach ($jadwals as $jadwal) {
                $cekPemesanan = Pemesanan::where('jadwal_id', $jadwal->id)->exists();
                if ($cekPemesanan) {
                    return back()->withErrors(['error' => 'Jadwal yang dipilih sudah dipesan. Silakan pilih waktu lain.']);
                }
            }
            foreach ($jadwals as $index => $jadwal) {
                // Hitung durasi bermain dalam jam
                $durasi = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;

                // Inisialisasi total harga
                $total_harga = 0;

                // Waktu mulai dalam format timestamp
                $jam_mulai = strtotime($request->jam_mulai);

                // Loop setiap jam
                for ($i = 0; $i < $durasi; $i++) {
                    // Jam saat ini dalam loop
                    $current_time = strtotime("+$i hour", $jam_mulai);
                    $current_hour = date('H:i', $current_time);

                    // Tentukan harga berdasarkan lapangan dan jam sekarang
                    if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                        if ($current_hour >= '07:00' && $current_hour < '17:00') {
                            $harga_per_jam = 300000;
                        } else {
                            $harga_per_jam = 350000;
                        }
                    } elseif ($request->lapangan >= 4 && $request->lapangan <= 5) {
                        if ($current_hour >= '07:00' && $current_hour < '17:00') {
                            $harga_per_jam = 400000;
                        } else {
                            $harga_per_jam = 450000;
                        }
                    } else {
                        $harga_per_jam = 0;
                    }

                    // Tambahkan ke total
                    $total_harga += $harga_per_jam;
                }

                if ($index === 0) {
                    $dp = $request->dp;
                    $sisa_bayar = max(0, $total_harga - $dp);
                    $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';
                } else {
                    $dp = null;
                    $sisa_bayar = null;
                    $status = null;
                }

                $user = Auth::user();
                if ($user) {
                    $pemesanan = Pemesanan::create([
                        'user_id' => $user->id,
                        'kode_pemesanan' => $kode_pemesanan,
                        'jadwal_id' => $jadwal->id,
                        'tanggal' => $request->tanggal,
                        'jam_mulai' => $request->jam_mulai,
                        'jam_selesai' => $request->jam_selesai,
                        'nama_tim' => $request->nama_tim,
                        'no_telepon' => $request->no_telepon,
                        'dp' => $dp,
                        'harga' => $total_harga,
                        'sisa_bayar' => $sisa_bayar,
                        'status' => $status,
                    ]);
                } else {
                    return response()->json(['error' => 'User not authenticated'], 401);
                }
            }
            NotifikasiHelper::kirimWhatsApp($pemesanan);

            // // Kirim Notifikasi WhatsApp
            // $this->KirimNotifikasiWhatsApp($pemesanan);

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
            'lapangan' => 'required|string',
            'jam_mulai' => 'required|array',
            'jam_selesai' => 'required|array',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'dp' => 'required|numeric|min:100000',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        DB::beginTransaction();
        try {
            $lastTanggal = null;  // Menyimpan tanggal pemesanan terakhir
            // Hitung total jumlah jadwal valid
            $jumlah_jadwal_valid = 0;
            foreach ($request->jam_mulai as $index => $mulai) {
                $selesai = $request->jam_selesai[$index];
                $tanggal = $request->tanggal[$index];
                if ($mulai && $selesai && $tanggal) {
                    $jumlah_jadwal_valid++;
                }
            }

            // Cegah pembagian 0
            if ($jumlah_jadwal_valid == 0) {
                return back()->withErrors(['error' => 'Tidak ada jadwal yang valid.']);
            }

            // Hitung DP per jadwal
            $dp_total = $request->dp;
            $dp_per_jadwal = $dp_total / $jumlah_jadwal_valid;

            foreach ($request->jam_mulai as $index => $mulai) {
                $selesai = $request->jam_selesai[$index];
                $tanggal = $request->tanggal[$index];

                if (!$mulai || !$selesai || !$tanggal) continue;

                if (strtotime($selesai) <= strtotime($mulai)) {
                    return back()->withErrors(['error' => 'Jam selesai harus lebih besar dari jam mulai di jadwal ke-' . ($index + 1)]);
                }

                $jadwals = Jadwal::where('tanggal', $tanggal)
                    ->where('lapangan', $request->lapangan)
                    ->where('jam', '>=', $mulai)
                    ->where('jam', '<', $selesai)
                    ->get();

                foreach ($jadwals as $jadwal) {
                    if (Pemesanan::where('jadwal_id', $jadwal->id)->exists()) {
                        return back()->withErrors(['error' => 'Jadwal ke-' . ($index + 1) . ' pada tanggal ' . $tanggal . ' sudah dipesan. Silakan pilih waktu lain.']);
                    }
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

                // $kode_pemesanan = strtoupper(substr(uniqid(), -5));

                // Perhitungan DP & sisa bayar per entri
                $dp = $dp_per_jadwal;
                $sisa_bayar = max(0, $total_harga - $dp - 25000);
                $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';

                foreach ($jadwals as $jadwal) {
                    $pemesanan = Pemesanan::create([
                        'user_id' => $user->id,
                        'kode_pemesanan' => $kode_pemesanan,
                        'jadwal_id' => $jadwal->id,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai,
                        'nama_tim' => $request->nama_tim,
                        'no_telepon' => $request->no_telepon,
                        'dp' => $dp,
                        'harga' => $total_harga,
                        'sisa_bayar' => $sisa_bayar,
                        'status' => $status,
                    ]);

                    $lastTanggal = $tanggal;
                }


                // Kirim notifikasi per entri (optional)
                NotifikasiHelper::kirimWhatsApp($pemesanan);
            }

            // Tambahkan logika untuk memasukkan data member
            if ($lastTanggal) {
                // Tanggal berakhir member diatur berdasarkan tanggal pemesanan terakhir
                $tanggal_berakhir = date('Y-m-d', strtotime($lastTanggal));

                // Masukkan data member
                Member::create([
                    'user_id' => $user->id,
                    'status' => 'aktif',
                    'tanggal_berakhir' => $tanggal_berakhir,
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
        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam')->get();

        return view('pemesanan.edit', compact('pemesanan', 'jadwals'));
    }

    // Method update
    public function update(Request $request, $kode_pemesanan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        $pemesananLama = Pemesanan::where('kode_pemesanan', $kode_pemesanan)->get();

        if ($pemesananLama->isEmpty()) {
            return back()->withErrors(['error' => 'Pemesanan tidak ditemukan.']);
        }

        $tanggalPemesanan = $pemesananLama->first()->tanggal;

        $tanggalSekarang = Carbon::now();
        $tanggalBatas = Carbon::parse($tanggalPemesanan)->subDay();

        if ($tanggalSekarang->greaterThan($tanggalBatas)) {
            return back()->with(['error' => 'Anda tidak dapat merubah jadwal kurang dari 1 hari sebelum hari bermain.']);
        }

        $dpLama = $pemesananLama->first()->dp;

        // Validasi jadwal baru
        $validationResponse = $this->validateSchedule($request);
        if (!$validationResponse->getData()->success) {
            return back()->with('error', $validationResponse->getData()->message);
        }

        DB::beginTransaction();
        try {
            // Hapus pemesanan lama
            foreach ($pemesananLama as $p) {
                $p->delete();
            }

            // Ambil jadwal baru
            $jadwalsBaru = Jadwal::where('tanggal', $request->tanggal)
                ->where('lapangan', $request->lapangan)
                ->where('jam', '>=', $request->jam_mulai)
                ->where('jam', '<', $request->jam_selesai)
                ->get();

            // Hitung total harga
            $durasi = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
            $total_harga = 0;

            for ($i = 0; $i < $durasi; $i++) {
                $current_time = strtotime("+$i hour", strtotime($request->jam_mulai));
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

            $user = Auth::user();
            $sisa_bayar = max(0, $total_harga - $dpLama);
            $status = ($sisa_bayar == 0) ? 'lunas' : 'belum lunas';

            foreach ($jadwalsBaru as $index => $jadwal) {
                Pemesanan::create([
                    'user_id' => $user->id,
                    'kode_pemesanan' => $kode_pemesanan,
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => $request->tanggal,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'nama_tim' => $request->nama_tim,
                    'no_telepon' => $request->no_telepon,
                    'dp' => $index === 0 ? $dpLama : null,
                    'harga' => $total_harga,
                    'sisa_bayar' => $index === 0 ? $sisa_bayar : null,
                    'status' => $index === 0 ? $status : null,
                ]);
            }
            $pemesananBaru = Pemesanan::where('kode_pemesanan', $kode_pemesanan)->first();
            NotifikasiHelper::kirimWhatsApp($pemesananBaru, true); // ini dari update

            DB::commit();
            return redirect()->route('pemesanan.detail')->with('success', 'Pemesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat update: ' . $e->getMessage());
        }
    }


    public function validateSchedule(Request $request)
    {
        $jadwals = Jadwal::where('tanggal', $request->tanggal)
            ->where('lapangan', $request->lapangan)
            ->where('jam', '>=', $request->jam_mulai)
            ->where('jam', '<', $request->jam_selesai)
            ->get();

        if ($jadwals->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Jadwal yang dipilih tidak tersedia!']);
        }

        foreach ($jadwals as $jadwal) {
            if (Pemesanan::where('jadwal_id', $jadwal->id)->exists()) {
                return response()->json(['success' => false, 'message' => 'Sebagian atau semua jadwal yang dipilih sudah dipesan!']);
            }
        }

        return response()->json(['success' => true]);
    }

    // private function KirimNotifikasiWhatsApp(Pemesanan $pemesanan, $isUpdated = false)
    // {
    //     $phoneNumber = $pemesanan->no_telepon;

    //     if (substr($phoneNumber, 0, 1) === '0') {
    //         $phoneNumber = '62' . substr($phoneNumber, 1);
    //     }

    //     if (!$pemesanan->tanggal || !$pemesanan->jam_selesai) {
    //         Log::error('Gagal mengirim notifikasi: Data tanggal atau jam_selesai tidak valid.');
    //         return;
    //     }

    //     try {
    //         $scheduleDateTime = Carbon::parse($pemesanan->tanggal . ' ' . $pemesanan->jam_selesai, 'Asia/Jakarta')->timestamp;
    //     } catch (\Exception $e) {
    //         Log::error('Format tanggal atau waktu salah: ' . $e->getMessage());
    //         return;
    //     }

    //     // ⬇️ Bedakan pesan tergantung apakah ini dari update atau store
    //     if ($isUpdated) {
    //         $message = "Hallo, {$pemesanan->nama_tim}. Jadwal bermain Anda telah diubah. Ini adalah pengingat terbaru. Waktu bermain selesai pada {$pemesanan->jam_selesai}, mohon selesaikan pembayaran tepat waktu.";
    //     } else {
    //         $message = "Hallo, {$pemesanan->nama_tim}. Terimakasih telah bermain di tempat kami. Waktu bermain Anda telah selesai, mohon untuk menyelesaikan pembayaran!";
    //     }

    //     $response = Http::withHeaders([
    //         'Authorization' => config('services.fonnte.token'),
    //     ])->asForm()->post('https://api.fonnte.com/send', [
    //         'target' => $phoneNumber,
    //         'message' => $message,
    //         'schedule' => $scheduleDateTime,
    //         'countryCode' => '',
    //     ]);

    //     Log::info("Fonnte API Response: " . $response->body());

    //     if ($response->failed()) {
    //         Log::error('Gagal mengirim notifikasi WhatsApp: ' . $response->body());
    //     }
    // }

    public function getSnapToken(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
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
}
