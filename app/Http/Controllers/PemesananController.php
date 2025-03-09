<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function create()
    {
        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam')->get();
        return view('pemesanan.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lapangan' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'nama_tim' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'dp' => 'required|numeric|min:100000',
        ], [
            'dp.min' => 'Jumlah DP minimal adalah 100.000!',
            'dp.required' => 'DP wajib diisi!',
            'dp.numeric' => 'DP harus berupa angka!',
        ]);

        // Cari ID Jadwal berdasarkan tanggal, lapangan, dan jam yang dipilih
        $jadwals = Jadwal::where('tanggal', $request->tanggal)
            ->where('lapangan', $request->lapangan)
            ->where('jam', '>=', $request->jam_mulai)
            ->where('jam', '<', $request->jam_selesai) // Hanya hingga sebelum jam selesai
            ->get();

        if ($jadwals->isEmpty()) {
            return back()->withErrors(['error' => 'Jadwal yang dipilih tidak tersedia!']);
        }

        // Cek apakah jadwal sudah dipesan
        foreach ($jadwals as $jadwal) {
            if (Pemesanan::where('jadwal_id', $jadwal->id)->exists()) {
                return back()->withErrors(['error' => 'Sebagian atau semua jadwal yang dipilih sudah dipesan!']);
            }
        }

        $kode_pemesanan = 'BOOK-' . strtoupper(uniqid());

        // Simpan setiap jadwal yang dipilih ke tabel pemesanan
        DB::beginTransaction();
        try {
            foreach ($jadwals as $index => $jadwal) {
                $pemesanan = Pemesanan::create([
                    'user_id' => auth()->id(),
                    'kode_pemesanan' => $kode_pemesanan,
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => $request->tanggal,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'nama_tim' => $request->nama_tim,
                    'no_telepon' => $request->no_telepon,
                    'dp' => $index === 0 ? $request->dp : null, // Hanya jam pertama yang memiliki DP
                ]);
            }

            // Mengirimkan notifikasi WhatsApp
            $this->KirimNotifikasiWhatsApp($pemesanan);

            DB::commit();
            return redirect()->route('jadwal.index')->with('success', 'Pemesanan berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    private function KirimNotifikasiWhatsApp(Pemesanan $pemesanan)
    {
        $phoneNumber = $pemesanan->no_telepon;

        // Ubah nomor telepon agar sesuai dengan format internasional
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        // Pastikan tanggal dan jam tidak null sebelum diproses
        if (!$pemesanan->tanggal || !$pemesanan->jam_selesai) {
            Log::error('Gagal mengirim notifikasi: Data tanggal atau jam_selesai tidak valid.');
            return;
        }

        // Perbaikan dalam parsing tanggal & jam selesai
        try {
            $scheduleDateTime = Carbon::parse($pemesanan->tanggal . ' ' . $pemesanan->jam_selesai, 'Asia/Jakarta')->timestamp;
        } catch (\Exception $e) {
            Log::error('Format tanggal atau waktu salah: ' . $e->getMessage());
            return;
        }

        $message = "Hallo, {$pemesanan->nama_tim}. Terimakasih telah bermain di tempat kami. Waktu bermain Anda telah selesai, mohon untuk menyelesaikan pembayaran!";

        // Kirim notifikasi WhatsApp menggunakan API Fonnte
        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'schedule' => $scheduleDateTime, // Sudah dalam format timestamp
            'countryCode' => '',
        ]);

        // Log untuk debugging
        Log::info("Fonnte API Response: " . $response->body());

        if ($response->failed()) {
            Log::error('Gagal mengirim notifikasi WhatsApp: ' . $response->body());
        }
    }
    public function getSnapToken(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . strtoupper(uniqid()), // Buat order ID unik
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
