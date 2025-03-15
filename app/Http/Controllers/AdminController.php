<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung total pengguna (user)
        $totalUsers = User::where('role', 'user')->count();

        // Menghitung total admin (hanya pengguna dengan role 'admin')
        $totalAdmin = User::where('role', 'admin')->count();

        // Menghitung total pemesanan dengan status "belum lunas"
        $totalBelumLunas = Pemesanan::where('status', 'belum lunas')->count();

        // Mengirim data ke view
        return view('admin.dashboard', compact('totalUsers', 'totalAdmin', 'totalBelumLunas'));
    }
    public function konfirmasiPelunasan(Request $request)
    {
        $request->validate([
            'kode_pemesanan' => 'required',
        ]);

        $pemesanan = Pemesanan::where('kode_pemesanan', $request->kode_pemesanan)->first();

        if ($pemesanan) {
            if ($pemesanan->status == "lunas") {
                return redirect()->route('admin.konfirmasi-pelunasan')->with('error', 'Kode pemesanan sudah digunakan (Lunas).');
            }
            // Ubah sisa bayar menjadi 0
            $pemesanan->sisa_bayar = 0;

            // Ubah status pembayaran menjadi "Lunas"
            $pemesanan->status = "Lunas";

            // Simpan perubahan
            $pemesanan->save();

            return redirect()->route('admin.konfirmasi-pelunasan')->with('success', 'Pelunasan berhasil dikonfirmasi.');
        } else {
            return redirect()->route('admin.konfirmasi-pelunasan')->with('error', 'Kode pemesanan tidak ditemukan.');
        }
    }

    public function dataPemesanan(Request $request)
    {
        $query = Pemesanan::query();

        // Filter berdasarkan search nama tim atau kode pemesanan
        if ($request->filled('search')) {
            $query->where('nama_tim', 'LIKE', '%' . $request->search . '%')
                ->orWhere('kode_pemesanan', 'LIKE', '%' . $request->search . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination (10 data per halaman)
        $pemesanan = $query->paginate(10);

        return view('admin.data-pemesanan', compact('pemesanan'));
    }
}
