<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardPointController;

// ===============================
// Rute Publik
// ===============================
Route::get('/', function () {
    return view('landing_page.partials.home');
});

// ===============================
// Dashboard (Autentikasi + Verifikasi)
// ===============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ===============================
// Manajemen Profil (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================
// Jadwal (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
});

// ===============================
// Pemesanan (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/detail', [PemesananController::class, 'index'])->name('pemesanan.detail');
    Route::get('/pemesanan/{kode_pemesanan}/edit', [PemesananController::class, 'edit'])->name('pemesanan.edit');
    Route::put('/pemesanan/{kode_pemesanan}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::post('/pemesanan/validateSchedule', [PemesananController::class, 'validateSchedule']);
    Route::post('/pemesanan/getSnapToken', [PemesananController::class, 'getSnapToken'])->name('pemesanan.getSnapToken');
});

// ===============================
// Reward Points (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/reward-points', [RewardPointController::class, 'index'])->name('reward.index');
    Route::get('/reward-points/invoice/{id}', [RewardPointController::class, 'invoice'])->name('reward.invoice');
    Route::get('/reward-points/{id}/invoice', [RewardPointController::class, 'downloadInvoice'])->name('reward.download-invoice');
});

// ===============================
// Admin (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/admin/data-user', [AdminController::class, 'dataUser'])->name('user.data-user');
});

// ===============================
// Panel Admin (Autentikasi + Middleware Admin)
// ===============================
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Konfirmasi Pelunasan
    Route::get('/admin/konfirmasi-pelunasan', function () {
        return view('admin.konfirmasi-pelunasan');
    })->name('admin.konfirmasi-pelunasan');
    Route::post('/admin/konfirmasi-pelunasan', [AdminController::class, 'konfirmasiPelunasan'])->name('admin.konfirmasi-pelunasan');

    // Data Pemesanan dan Reward
    Route::get('/admin/pemesanan', [AdminController::class, 'dataPemesanan'])->name('admin.data-pemesanan');
    Route::get('/admin/reward-points', [AdminController::class, 'dataRewardPoint'])->name('admin.reward-points');

    // Konfirmasi Penukaran Poin
    Route::get('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'showKonfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin');
    Route::post('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'konfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin.submit');

    // Manajemen Admin
    Route::get('/admin/data-admin', [AdminController::class, 'dataAdmin'])->name('admin.data-admin');
    Route::get('/admin/tambah-admin', [AdminController::class, 'createAdmin'])->name('admin.create');
    Route::post('/admin/tambah-admin', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');

    // Pemesanan oleh Admin
    Route::get('/admin/pemesanan/create', [AdminController::class, 'createPemesanan'])->name('admin.pemesanan.create');
    Route::post('/admin/pemesanan/store', [AdminController::class, 'storePemesanan'])->name('admin.pemesanan.store');
    Route::get('/admin/pemesanan/{id}/edit', [AdminController::class, 'editPemesanan'])->name('admin.editPemesanan');
    Route::post('/admin/pemesanan/{id}/update', [AdminController::class, 'updatePemesanan'])->name('admin.updatePemesanan');
});

// ===============================
// Rute Auth
// ===============================
require __DIR__ . '/auth.php';

