<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Jadwal;
use App\Models\Keuangan;
use App\Models\Member;
use App\Models\Refund;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\RewardPoint;
use Carbon\Carbon;
use App\Helpers\NotifikasiHelper;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index()
    {
        // Menghitung total pengguna (user)
        $totalUsers = User::where('role', 'user')->count();

        // Menghitung total admin (hanya pengguna dengan role 'admin')
        $totalAdmin = User::where('role', 'admin')->count();

        // Menghitung total pemesanan dengan status "belum lunas" (hanya yang berlangsung pada hari ini)
        $totalBelumLunas = Pemesanan::where('status', 'belum lunas')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Menghitung total pendapatan (sum dari jumlah) untuk bulan ini
        $pendapatanBulanIni = Keuangan::where('bulan', Carbon::now()->format('Y-m'))
            ->sum('jumlah');

        // Menghitung total pendapatan keseluruhan
        $totalPendapatan = Keuangan::sum('jumlah');

        // Menghitung total pengajuan refund
        $totalPengajuanRefund = Refund::where('status', 'diajukan')->count();

        // Mengirim data ke view
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin',
            'totalBelumLunas',
            'pendapatanBulanIni',
            'totalPendapatan',
            'totalPengajuanRefund'
        ));
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

        if (!$pemesanan) {
            return redirect()->route('admin.konfirmasi-pelunasan')->with('error', 'Kode pemesanan tidak ditemukan.');
        }

        if ($pemesanan->status == "lunas") {
            return redirect()->route('admin.konfirmasi-pelunasan')->with('error', 'Kode pemesanan sudah digunakan (Lunas).');
        }

        // Hitung total pembayaran (DP + Sisa Bayar)
        $total_pembayaran = $pemesanan->dp + $pemesanan->sisa_bayar;

        // Ubah sisa bayar menjadi 0 dan status menjadi "Lunas"
        $pemesanan->sisa_bayar = 0;
        $pemesanan->status = "Lunas";
        $pemesanan->save();

        // === LOGIKA PENAMBAHAN REWARD POINT ===
        $durasi = (strtotime($pemesanan->jam_selesai) - strtotime($pemesanan->jam_mulai)) / 3600;
        $point_baru = $durasi; // 1 jam = 1 point
        $nominal_cashback = 0;

        // Tentukan nominal cashback berdasarkan lapangan
        if ($pemesanan->jadwal->lapangan >= 1 && $pemesanan->jadwal->lapangan <= 3) {
            $nominal_cashback = $point_baru * 30000;
        } elseif ($pemesanan->jadwal->lapangan >= 4 && $pemesanan->jadwal->lapangan <= 5) {
            $nominal_cashback = $point_baru * 40000;
        }

        // Cek apakah tim sudah ada di reward_points
        $reward = RewardPoint::where('kode_tim', $pemesanan->nama_tim)->first();

        if ($reward) {
            // Jika sudah ada, update
            $reward->update([
                'point' => $reward->point + $point_baru,
                'idr' => $reward->idr + $nominal_cashback,
            ]);
        } else {
            // Jika belum ada, buat baru
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

        // === CATAT KE TABEL KEUANGAN (PAKAI TANGGAL JADWAL MAIN, BUKAN now()) ===
        $tanggal_main = $pemesanan->jadwal->tanggal; // pastikan relasi jadwal ada
        $bulan_main = date('Y-m', strtotime($tanggal_main));

        Keuangan::create([
            'tanggal' => $tanggal_main,
            'bulan' => $bulan_main,
            'jumlah' => $total_pembayaran,
            // 'keterangan' => 'Pelunasan kode pemesanan: ' . $pemesanan->kode_pemesanan,
        ]);

        return redirect()->route('admin.konfirmasi-pelunasan')->with('success', 'Pelunasan berhasil dikonfirmasi. Reward point telah ditambahkan dan keuangan tercatat.');
    }
    public function konfirmasiPenukaranPoin(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required',
        ]);

        // Cari reward point berdasarkan kode voucher
        $rewardPoint = RewardPoint::where('kode_voucher', $request->kode_voucher)->first();

        if ($rewardPoint) {
            // Jika reward point belum 10, tidak bisa ditukar
            if ($rewardPoint->point < 10) {
                return redirect()->route('admin.konfirmasi-penukaran-poin')->with('error', 'Mohon maaf, point anda belum mencapai 10. Silakan bermain terlebih dahulu dan kumpulkan point anda untuk melakukan penukaran.');
            }

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
        $query = Pemesanan::select('pemesanan.*')
            ->whereRaw('id = (select min(id) from pemesanan as p2 where p2.kode_pemesanan = pemesanan.kode_pemesanan)');

        // Filter berdasarkan search nama tim atau kode pemesanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tim', 'LIKE', '%' . $search . '%')
                    ->orWhere('kode_pemesanan', 'LIKE', '%' . $search . '%');
            });
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
    // Method untuk menampilkan form tambah pemesanan (admin)
    public function createPemesanan()
    {
        $jadwals = Jadwal::orderBy('tanggal')->orderBy('jam')->get();
        return view('admin.pemesanan.create', compact('jadwals'));
    }
    // Method untuk menyimpan pemesanan yang dilakukan oleh admin
    public function storePemesanan(Request $request)
    {
        $request->validate([
            'tanggal'          => 'required|date',
            'lapangan'         => 'required|string',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required|after:jam_mulai',
            'nama_tim'         => 'required|string|max:255',
            'no_telepon'       => 'required|string|max:15',
            'dp'               => 'nullable|numeric|min:100000',
            'jenis_pemesanan'  => 'required|in:gratis,bayar',
        ]);

        // Cari jadwal sesuai filter
        $jadwals = Jadwal::where('tanggal', $request->tanggal)
            ->where('lapangan', $request->lapangan)
            ->where('jam', '>=', $request->jam_mulai)
            ->where('jam', '<', $request->jam_selesai)
            ->get();

        // Cek ketersediaan jadwal
        if ($jadwals->isEmpty()) {
            return back()->with('error', 'Jadwal yang dipilih tidak tersedia!');
        }
        foreach ($jadwals as $jadwal) {
            if (Pemesanan::where('jadwal_id', $jadwal->id)->exists()) {
                return back()->with('error', 'Sebagian atau semua jadwal yang dipilih sudah dipesan!');
            }
        }

        $kode_pemesanan = strtoupper(substr(uniqid(), -5));
        $user = Auth::user();
        if (! $user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        DB::beginTransaction();
        try {
            // Hitung durasi dan total harga satu kali (sama untuk semua entri)
            $durasi = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
            $jam_mulai = strtotime($request->jam_mulai);
            $total_harga = 0;
            for ($i = 0; $i < $durasi; $i++) {
                $current_hour = date('H:i', strtotime("+$i hour", $jam_mulai));
                if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                    $total_harga += ($current_hour >= '07:00' && $current_hour < '17:00') ? 300000 : 350000;
                } elseif ($request->lapangan >= 4 && $request->lapangan <= 5) {
                    $total_harga += ($current_hour >= '07:00' && $current_hour < '17:00') ? 400000 : 450000;
                }
            }

            $is_gratis = ($request->jenis_pemesanan === 'gratis');

            // Pre-calculate untuk entri pertama
            $dp_awal      = $is_gratis ? null : $request->dp;
            $sisa_bayar_awal = $is_gratis ? 0 : max(0, $total_harga - $dp_awal);
            $status_awal     = ($is_gratis || $sisa_bayar_awal === 0) ? 'lunas' : 'belum lunas';

            // Simpan per entri jadwal
            foreach ($jadwals as $index => $jadwal) {
                // Entri pertama: pakai dp_awal, sisa_bayar_awal, status_awal
                if ($index === 0) {
                    $dp         = $dp_awal;
                    $sisa_bayar = $sisa_bayar_awal;
                    $status     = $status_awal;
                } else {
                    // Entri ke-2+ : kosongkan ketiga field
                    $dp         = null;
                    $sisa_bayar = null;
                    $status     = null;
                }

                $pemesanan = Pemesanan::create([
                    'user_id'       => $user->id,
                    'kode_pemesanan' => $kode_pemesanan,
                    'jadwal_id'     => $jadwal->id,
                    'tanggal'       => $request->tanggal,
                    'jam_mulai'     => $request->jam_mulai,
                    'jam_selesai'   => $request->jam_selesai,
                    'nama_tim'      => $request->nama_tim,
                    'no_telepon'    => $request->no_telepon,
                    'dp'            => $dp,
                    'harga'         => $total_harga,
                    'sisa_bayar'    => $sisa_bayar,
                    'status'        => $status,
                ]);
            }



            if (!$is_gratis) {
                NotifikasiHelper::kirimWhatsApp($pemesanan);
            }

            DB::commit();
            return redirect()->route('admin.data-pemesanan')
                ->with('success', 'Pemesanan berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
    public function editPemesanan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $jadwal = Jadwal::all(); // Jika ingin opsi jadwal

        if ($pemesanan->status === 'lunas') {
            return redirect()->route('admin.data-pemesanan')->with('error', 'Pemesanan sudah lunas dan tidak dapat diubah.');
        }

        return view('admin.edit-pemesanan', compact('pemesanan', 'jadwal'));
    }
    public function updatePemesanan(Request $request, $id)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'lapangan'     => 'required|string',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required|after:jam_mulai',
            'nama_tim'     => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:15',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status === 'lunas') {
            return redirect()->route('admin.data-pemesanan')
                ->with('error', 'Pemesanan sudah lunas dan tidak dapat diubah.');
        }

        // validasi jadwal bentrok
        $validationResponse = $this->validateSchedule($request);
        if (!$validationResponse->getData()->success) {
            return back()->with('error', $validationResponse->getData()->message);
        }

        DB::beginTransaction();
        try {
            $user_id        = $pemesanan->user_id;
            $kode_pemesanan = $pemesanan->kode_pemesanan;
            $dp_awal        = $pemesanan->dp; // DP lama

            // hapus semua entri lama
            Pemesanan::where('kode_pemesanan', $kode_pemesanan)->delete();

            // ambil jadwal baru
            $jadwalsBaru = Jadwal::where('tanggal', $request->tanggal)
                ->where('lapangan', $request->lapangan)
                ->where('jam', '>=', $request->jam_mulai)
                ->where('jam', '<',  $request->jam_selesai)
                ->get();

            // hitung total harga satu kali
            $durasi       = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
            $jam_mulai_ts = strtotime($request->jam_mulai);
            $total_harga  = 0;
            for ($i = 0; $i < $durasi; $i++) {
                $current_hour = date('H:i', strtotime("+{$i} hour", $jam_mulai_ts));
                if ($request->lapangan >= 1 && $request->lapangan <= 3) {
                    $total_harga += ($current_hour >= '07:00' && $current_hour < '17:00')
                        ? 300000
                        : 350000;
                } else {
                    $total_harga += ($current_hour >= '07:00' && $current_hour < '17:00')
                        ? 400000
                        : 450000;
                }
            }

            // hitung sisa bayar + status untuk entri pertama
            $sisa_bayar_awal = max(0, $total_harga - $dp_awal);
            $status_awal     = ($sisa_bayar_awal == 0) ? 'lunas' : 'belum lunas';

            // tulis ulang entri baru
            foreach ($jadwalsBaru as $index => $jadwal) {
                if ($index === 0) {
                    $dp          = $dp_awal;
                    $sisa_bayar  = $sisa_bayar_awal;
                    $status      = $status_awal;
                } else {
                    $dp          = null;
                    $sisa_bayar  = null;
                    $status      = null;
                }

                Pemesanan::create([
                    'user_id'        => $user_id,
                    'kode_pemesanan' => $kode_pemesanan,
                    'jadwal_id'      => $jadwal->id,
                    'tanggal'        => $request->tanggal,
                    'jam_mulai'      => $request->jam_mulai,
                    'jam_selesai'    => $request->jam_selesai,
                    'nama_tim'       => $request->nama_tim,
                    'no_telepon'     => $request->no_telepon,
                    'dp'             => $dp,
                    'harga'          => $total_harga,
                    'sisa_bayar'     => $sisa_bayar,
                    'status'         => $status,
                ]);
            }

            $pemesananBaru = Pemesanan::where('kode_pemesanan', $kode_pemesanan)->first();
            NotifikasiHelper::kirimWhatsApp($pemesananBaru, true);

            DB::commit();
            return redirect()->route('admin.data-pemesanan')
                ->with('success', 'Pemesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.data-pemesanan')
                ->with('error', 'Terjadi kesalahan saat update: ' . $e->getMessage());
        }
    }
    public function hapusPemesanan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        if ($pemesanan->status === 'lunas') {
            return redirect()->route('admin.data-pemesanan')
                ->with('error', 'Pemesanan sudah lunas dan tidak dapat dihapus.');
        }
        
        DB::beginTransaction();
        try {
            // hapus semua entri lama
            Pemesanan::where('kode_pemesanan', $pemesanan->kode_pemesanan)->delete();
            DB::commit();
            return redirect()->route('admin.data-pemesanan')
                ->with('success', 'Pemesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.data-pemesanan')
                ->with('error', 'Terjadi kesalahan saat hapus: ' . $e->getMessage());
        }
    }
    
    public function dataMember()
    {
        $members = Member::where('status', 'aktif')->get();
        return view('admin.data-member', compact('members'));
    }
}

