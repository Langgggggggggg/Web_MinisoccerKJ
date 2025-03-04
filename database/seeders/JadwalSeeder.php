<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Jumlah hari di setiap bulan berdasarkan permintaan
        $jumlahHariPerBulan = [
            '03' => 28, // Maret
            '04' => 30, // April
            '05' => 31, // Mei
            '06' => 30, // Juni
            '07' => 31, // Juli
            '08' => 31, // Agustus
            '09' => 30, // September
            '10' => 31, // Oktober
            '11' => 30, // November
            '12' => 31  // Desember
        ];

        $tanggalMulai = strtotime('2025-03-01'); // Mulai dari 1 Maret 2025
        $tanggalAkhir = strtotime('2025-12-31'); // Sampai 31 Desember 2025

        while ($tanggalMulai <= $tanggalAkhir) {
            $tahun = date('Y', $tanggalMulai);
            $bulan = date('m', $tanggalMulai);
            $tanggal = date('d', $tanggalMulai);
            $hari = date('w', $tanggalMulai); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu

            // Periksa apakah bulan memiliki batasan hari yang sudah ditentukan
            if (isset($jumlahHariPerBulan[$bulan]) && $tanggal > $jumlahHariPerBulan[$bulan]) {
                // Lompat ke bulan berikutnya pada tanggal 1
                $tanggalMulai = strtotime($tahun . '-' . $bulan . '-01 +1 month');
                continue;
            }

            // Lewati hari Senin
            if ($hari == 1) {
                $tanggalMulai = strtotime('+1 day', $tanggalMulai);
                continue;
            }

            // Loop untuk setiap lapangan dan jam
            for ($lapangan = 1; $lapangan <= 5; $lapangan++) {
                for ($jam = 7; $jam <= 23; $jam++) {
                    DB::table('jadwal')->insert([
                        'tanggal' => date('Y-m-d', $tanggalMulai),
                        'jam' => sprintf('%02d:00:00', $jam),
                        'lapangan' => $lapangan,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Pindah ke hari berikutnya
            $tanggalMulai = strtotime('+1 day', $tanggalMulai);
        }
    }
}
