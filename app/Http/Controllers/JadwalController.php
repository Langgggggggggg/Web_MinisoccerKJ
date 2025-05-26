<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', date('Y-m-d'));

        // Ambil semua data pemesanan
        $rawPemesanan = Pemesanan::orderBy('tanggal')->orderBy('jam_mulai')->get();

        // Siapkan koleksi baru untuk menyimpan hasil ekspansi jadwal per jam
        $expandedJadwals = collect();

        foreach ($rawPemesanan as $pemesanan) {
            $start = Carbon::parse($pemesanan->jam_mulai);
            $end = Carbon::parse($pemesanan->jam_selesai);
            $durationInHours = $start->diffInHours($end);

            for ($i = 0; $i < $durationInHours; $i++) {
                $hourSlot = $start->copy()->addHours($i)->format('H:i');

                $expandedJadwals->push((object) [
                    'tanggal' => $pemesanan->tanggal,
                    'jam' => $hourSlot,
                    'lapangan' => $pemesanan->lapangan,
                    'nama_tim' => $pemesanan->nama_tim,
                    // Tampilkan dp hanya di jam pertama (i == 0), selebihnya null
                    'dp' => $i === 0 ? $pemesanan->dp : null,
                ]);
            }
        }

        // Group by tanggal agar sesuai dengan logika view sebelumnya
        $groupedByDate = $expandedJadwals->groupBy('tanggal');

        return view('jadwal.index', [
            'jadwals' => $groupedByDate,
            'selectedDate' => $tanggal,
        ]);
    }
}
