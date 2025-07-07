<?php
namespace App\Helpers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifikasiHelper
{
    public static function kirimNotifikasiPembayaran(Pemesanan $pemesanan, $isUpdated = false)
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

        if ($isUpdated) {
            $message = "Hallo *{$pemesanan->nama_tim}* ⚽,\n\n"
                . "ℹ️ Kami informasikan bahwa jadwal bermain Anda sebelumnya telah diperbarui. "
                . "⏰ Waktu bermain anda sekarang yang diperbarui sudah berakhir pada pukul *{$pemesanan->jam_selesai}*. "
                . "💳 Mohon segera menyelesaikan pembayaran di kasir kami.\n\n"
                . "🙏 Terima kasih telah bermain di Minisoccer KJ. "
                . "👋 Kami menantikan kunjungan Anda kembali!";
        } else {
            $message = "Hallo *{$pemesanan->nama_tim}* ⚽,\n\n"
                . "⏰ Waktu bermain Anda telah selesai pada pukul *{$pemesanan->jam_selesai}*. "
                . "💳 Mohon segera menyelesaikan pembayaran di kasir kami.\n\n"
                . "🙏 Terima kasih telah bermain di Minisoccer KJ. "
                . "👋 Kami menantikan kunjungan Anda kembali!";
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

    public static function kirimNotifikasiDetailPemesanan(Pemesanan $pemesanan)
    {
        // Ini adalah fungsi yang sebelumnya bernama kirimNotifikasiPemesananBaru
        // Logic tetap sama seperti sebelumnya
        $phoneNumber = $pemesanan->no_telepon;

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $message = "Halo, *{$pemesanan->nama_tim}*!\n\n"
            . "Terima kasih telah melakukan pemesanan di Minisoccer KJ.\n\n"
            . "*Detail Pemesanan:*\n"
            . "🏟️ Lapangan: {$pemesanan->lapangan}\n"
            . "📅 Tanggal: " . date('d/m/Y', strtotime($pemesanan->tanggal)) . "\n"
            . "⏰ Jam Main: {$pemesanan->jam_mulai} - {$pemesanan->jam_selesai}\n"
            . "💰 Total Harga: Rp " . number_format($pemesanan->harga, 0, ',', '.') . "\n"
            . "💳 DP: Rp " . number_format($pemesanan->dp, 0, ',', '.') . "\n"
            . "🔄 Sisa Bayar: Rp " . number_format($pemesanan->sisa_bayar, 0, ',', '.') . "\n\n"
            . "Silahkan datang 15 menit sebelum jadwal bermain.\n"
            . "Kode Pemesanan: *{$pemesanan->kode_pemesanan}*";

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '',
        ]);

        Log::info("Fonnte API Response for new booking: " . $response->body());

        if ($response->failed()) {
            Log::error('Gagal mengirim notifikasi WhatsApp pemesanan baru: ' . $response->body());
        }
    }

    public static function kirimNotifikasiDetailMember(array $pemesananList)
    {
        if (empty($pemesananList)) {
            Log::error('Tidak ada pesanan untuk dikirimkan dalam notifikasi member.');
            return;
        }

        // Ambil nomor telepon dari pesanan pertama (diasumsikan semua pesanan memiliki nomor telepon yang sama)
        $phoneNumber = $pemesananList[0]['no_telepon'];

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        // Gabungkan semua detail pesanan ke dalam satu pesan
        $message = "Halo, *{$pemesananList[0]['nama_tim']}*!\n\n"
            . "Selamat! Anda telah menjadi member aktif di Minisoccer KJ.\n\n"
            . "Berikut adalah detail pesanan Anda:\n";

        foreach ($pemesananList as $index => $pemesanan) {
            $message .= "\n*Detail Pesanan " . ($index + 1) . ":*\n"
                . "🏟️ Lapangan: {$pemesanan['lapangan']}\n"
                . "📅 Tanggal: " . date('d/m/Y', strtotime($pemesanan['tanggal'])) . "\n"
                . "⏰ Jam Main: {$pemesanan['jam_mulai']} - {$pemesanan['jam_selesai']}\n"
                . "💰 Total Harga: Rp " . number_format($pemesanan['harga'], 0, ',', '.') . "\n"
                . "💳 DP: Rp " . number_format($pemesanan['dp'], 0, ',', '.') . "\n"
                . "🔄 Sisa Bayar: Rp " . number_format($pemesanan['sisa_bayar'], 0, ',', '.') . "\n";
        }

        $message .= "\nTerima kasih telah menjadi member kami. Nikmati berbagai keuntungan eksklusif sebagai member aktif.";

        // Kirim pesan melalui API Fonnte
        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '',
        ]);

        Log::info("Fonnte API Response for member detail: " . $response->body());

        if ($response->failed()) {
            Log::error('Gagal mengirim notifikasi WhatsApp detail member: ' . $response->body());
        }
    }
}
