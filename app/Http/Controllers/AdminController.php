<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\RewardPoint;
use Illuminate\Support\Facades\Auth;


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
    public function dataAdmin()
    {
        // Mengambil data pengguna dengan role admin
        $admins = User::where('role', 'admin')->paginate(10);

        return view('admin.data-admin', compact('admins'));
    }
    public function dataUser()
    {
        // Mengambil data pengguna dengan role admin
        $users = User::where('role', 'user')->paginate(10);

        return view('user.data-user', compact('users'));
    }

    // Menampilkan halaman tambah admin
    public function createAdmin()
    {
        return view('admin.tambah-admin');
    }
    public function edit($id)
    {
        $admin = Auth::user();
    
        if ($admin->id != $id) {
            return redirect()->route('admin.data-admin')->with('error', 'Anda tidak memiliki izin untuk mengedit admin lain.');
        }   
    
        return view('admin.edit', compact('admin'));
    }
    
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id); // Ambil admin berdasarkan ID
    
        if (Auth::id() != $admin->id) { // Pastikan yang login hanya bisa edit dirinya sendiri
            return redirect()->route('admin.data-admin')->with('error', 'Anda tidak memiliki izin untuk mengedit admin lain.');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        // Update data admin
        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);
    
        return redirect()->route('admin.data-admin')->with('success', 'Data admin berhasil diperbarui.');
    }
    
    // Menyimpan admin baru
    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan admin baru ke database
        User::create([
            'name' => $request->name,
            'username' => $request->username, // Menambahkan username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin' // Pastikan ada kolom 'role' di tabel users
        ]);

        return redirect()->route('admin.data-admin')->with('success', 'Admin baru berhasil ditambahkan.');
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

            // === LOGIKA PENAMBAHAN REWARD POINT ===
            $durasi = (strtotime($pemesanan->jam_selesai) - strtotime($pemesanan->jam_mulai)) / 3600;

            // Perhitungan reward point
            $point_baru = $durasi; // 1 jam bermain = 1 point
            $nominal_cashback = 0;

            // Tentukan nominal cashback berdasarkan lapangan
            if ($pemesanan->jadwal->lapangan >= 1 && $pemesanan->jadwal->lapangan <= 3) {
                $nominal_cashback = $point_baru * 30000;
            } elseif ($pemesanan->jadwal->lapangan >= 4 && $pemesanan->jadwal->lapangan <= 5) {
                $nominal_cashback = $point_baru * 40000;
            }

            // Cek apakah tim sudah memiliki data di tabel reward_points
            $reward = RewardPoint::where('kode_tim', $pemesanan->nama_tim)->first();

            if ($reward) {
                // Jika sudah ada, update data point dan nominal IDR
                $reward->update([
                    'point' => $reward->point + $point_baru,
                    'idr' => $reward->idr + $nominal_cashback,
                ]);
            } else {
                // Jika belum ada, buat data baru dengan kode voucher otomatis
                $kode_voucher = strtoupper(substr(uniqid(), -5));

                RewardPoint::create([
                    'user_id' => $pemesanan->user_id,
                    'kode_tim' => $pemesanan->nama_tim,
                    'nama_tim' => $pemesanan->nama_tim,
                    'point' => $point_baru,
                    'idr' => $nominal_cashback,
                    'kode_voucher' => $kode_voucher,
                ]);
            }

            return redirect()->route('admin.konfirmasi-pelunasan')->with('success', 'Pelunasan berhasil dikonfirmasi. Reward point telah ditambahkan.');
        } else {
            return redirect()->route('admin.konfirmasi-pelunasan')->with('error', 'Kode pemesanan tidak ditemukan.');
        }
    }

    public function konfirmasiPenukaranPoin(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required',
        ]);

        // Cari reward point berdasarkan kode voucher
        $rewardPoint = RewardPoint::where('kode_voucher', $request->kode_voucher)->first();

        if ($rewardPoint) {
            // Hapus reward point dari database (karena sudah ditukar)
            $rewardPoint->delete();

            return redirect()->route('admin.konfirmasi-penukaran-poin')->with('success', 'Penukaran poin berhasil dikonfirmasi.');
        } else {
            return redirect()->route('admin.konfirmasi-penukaran-poin')->with('error', 'Kode voucher tidak ditemukan.');
        }
    }
    public function showKonfirmasiPenukaranPoin()
    {
        return view('admin.konfirmasi-penukaran-poin');
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
    public function dataRewardPoint()
    {
        // Mengambil data reward points dengan relasi user, diurutkan dari yang terbesar ke terkecil
        $rewardPoints = RewardPoint::with('user')
            ->orderBy('point', 'desc') // Mengurutkan berdasarkan jumlah poin terbanyak
            ->paginate(10);

        return view('admin.data-reward-point', compact('rewardPoints'));
    }
}
