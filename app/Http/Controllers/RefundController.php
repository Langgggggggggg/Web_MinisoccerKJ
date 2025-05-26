<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refund;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::where('user_id', Auth::id())->with('pemesanan')->latest()->get();
        return view('refunds.index', compact('refunds'));
    }

    public function create($pemesanan_id)
    {
        $pemesanan = Pemesanan::findOrFail($pemesanan_id);

        // Cek kepemilikan dan apakah sudah ada pengajuan refund
        if ($pemesanan->user_id !== Auth::id() || $pemesanan->refund) {
            abort(403);
        }
        // Cek apakah hari ini adalah H-1 sebelum tanggal bermain
        $tanggalMain = Carbon::parse($pemesanan->tanggal);
        $hariIni = Carbon::now()->startOfDay();
        // Cek apakah sudah pernah mengajukan refund yang masih diproses
        $sudahRefund = Refund::where('pemesanan_id', $pemesanan->id)
            ->whereIn('status', ['diajukan']) // sesuaikan status sesuai sistem kamu
            ->exists();

        if ($sudahRefund) {
            return redirect()->back()->with('error', 'Anda telah mengajukan refund sebelumnya dan sedang dalam proses. Silakan cek statusnya di halaman daftar pengajuan refund.');
        }

        if ($hariIni->equalTo($tanggalMain->subDay())) {
            return redirect()->back()->with('error', 'Anda tidak bisa dapat mengajukan refund karena hari ini adalah H-1 sebelum tanggal bermain.');
        }

        return view('refunds.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'alasan' => 'required|string|max:255'
        ]);

        $pemesanan = Pemesanan::findOrFail($request->pemesanan_id);

        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil data yang disalin
        $kodePemesanan = $pemesanan->kode_pemesanan;
        $lapangan = $pemesanan->lapangan;
        $tanggal = $pemesanan->tanggal;
        $jamBermain = $pemesanan->jam_mulai . ' - ' . $pemesanan->jam_selesai;
        $dp = $pemesanan->dp;

        Refund::create([
            'user_id' => Auth::id(),
            'pemesanan_id' => $pemesanan->id,
            'alasan' => $request->alasan,
            'kode_pemesanan' => $kodePemesanan,
            'lapangan' => $lapangan,
            'tanggal' => $tanggal,
            'jam_bermain' => $jamBermain,
            'idr' => $dp,
        ]);

        return redirect()->route('refunds.index')->with('success', 'Pengajuan refund berhasil dikirim.');
    }
}
