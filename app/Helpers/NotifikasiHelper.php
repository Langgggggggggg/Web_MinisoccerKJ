<?php
namespace App\Helpers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifikasiHelper
{
    public static function kirimWhatsApp(Pemesanan $pemesanan, $isUpdated = false)
    {
        $phoneNumber = $pemesanan->no_telepon;

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        if (!$pemesanan->tanggal || !$pemesanan->jam_selesai) {
            Log::error('Gagal mengirim notifikasi: Data tanggal atau jam_selesai tidak valid.');
            return;
        }

        try {
            $scheduleDateTime = Carbon::parse($pemesanan->tanggal . ' ' . $pemesanan->jam_selesai, 'Asia/Jakarta')->timestamp;
        } catch (\Exception $e) {
            Log::error('Format tanggal atau waktu salah: ' . $e->getMessage());
            return;
        }

        // Bedakan pesan tergantung apakah ini dari update atau store
        if ($isUpdated) {
            $message = "Hallo, {$pemesanan->nama_tim}. Jadwal bermain Anda telah diubah. Ini adalah pengingat terbaru. Waktu bermain selesai pada {$pemesanan->jam_selesai}, mohon selesaikan pembayaran tepat waktu.";
        } else {
            $message = "Hallo, {$pemesanan->nama_tim}. Terimakasih telah bermain di tempat kami. Waktu bermain Anda telah selesai, mohon untuk menyelesaikan pembayaran!";
        }

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'schedule' => $scheduleDateTime,
            'countryCode' => '',
        ]);

        Log::info("Fonnte API Response: " . $response->body());

        if ($response->failed()) {
            Log::error('Gagal mengirim notifikasi WhatsApp: ' . $response->body());
        }
    }
}
