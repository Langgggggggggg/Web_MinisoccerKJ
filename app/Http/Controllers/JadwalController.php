<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwals = Jadwal::with('pemesanan')->orderBy('tanggal')->orderBy('jam')->get();
        return view('jadwal.index', compact('jadwals'));
    }
}
