<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardPointController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\RefundAdminController;
use  App\Http\Controllers\InformationController;
use App\Http\Controllers\PenawaranMemberController;
// ===============================
// Rute Publik
// ===============================
Route::get('/', function () {
    return view('landing_page.partials.home');
});
Route::get('/tatacara-pemesanan', function () {
    return view('landing_page.information.tatacara-pemesanan');
});
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// ===============================
// Dashboard (Autentikasi + Verifikasi)
// ===============================
// ===============================
// Manajemen Profil (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});;

Route::middleware(['auth'])->group(function () {});
Route::get('/informasi', [InformationController::class, 'publicIndex'])->name('landing.information.index');
// Halaman informasi detail publik
Route::get('/informasi/{slug}', [InformationController::class, 'show'])->name('information.show');
// ===============================
// Jadwal (Autentikasi)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
});
// ===============================
// Midtrans Callback (Tanpa Middleware CSRF)
Route::post('/midtrans/callback', [PemesananController::class, 'midtransCallback'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
// ===============================
// Pemesanan (Autentikasi)
// ===============================
Route::middleware(['auth', \App\Http\Middleware\UserMiddleware::class])->group(function () {
    // Pemesanan
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/detail', [PemesananController::class, 'index'])->name('pemesanan.detail');
    Route::get('/pemesanan/{kode_pemesanan}/edit', [PemesananController::class, 'edit'])->name('pemesanan.edit');
    Route::put('/pemesanan/{kode_pemesanan}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::post('/pemesanan/validateSchedule', [PemesananController::class, 'validateSchedule']);
    Route::post('/pemesanan/getSnapToken', [PemesananController::class, 'getSnapToken'])->name('pemesanan.getSnapToken');
    Route::post('/pemesanan/getBookedSchedules', [PemesananController::class, 'getBookedSchedules'])->name('pemesanan.getBookedSchedules');

    // Reward Points
    Route::get('/reward-points', [RewardPointController::class, 'index'])->name('reward.index');
    Route::get('/reward-points/invoice/{id}', [RewardPointController::class, 'invoice'])->name('reward.invoice');
    Route::get('/reward-points/{id}/invoice', [RewardPointController::class, 'downloadInvoice'])->name('reward.download-invoice');
    Route::get('/dashboard', [PenawaranMemberController::class, 'index'])->name('dashboard');
    Route::get('/member/create', [PenawaranMemberController::class, 'create'])
        ->name('member.create')
    ;
    Route::post('/pemesanan/member', [PemesananController::class, 'storeMember'])->name('pemesanan.storeMember');

    Route::get('/refund', [RefundController::class, 'index'])->name('refunds.index');
    Route::get('/refunds/create/{pemesanan_id}', [RefundController::class, 'create'])->name('refunds.create');
    Route::post('/refunds', [RefundController::class, 'store'])->name('refunds.store');
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

    // Di dalam grup middleware admin
    Route::post('/admin/pemesanan/getBookedSchedules', [AdminController::class, 'getBookedSchedules'])->name('admin.pemesanan.getBookedSchedules');
    // Data Pemesanan dan Reward
    Route::get('/admin/pemesanan', [AdminController::class, 'dataPemesanan'])->name('admin.data-pemesanan');
    Route::get('/admin/reward-points', [AdminController::class, 'dataRewardPoint'])->name('admin.reward-points');

    // Route untuk pengelolaan keuangan
    Route::get('/admin/keuangan', [KeuanganController::class, 'dataKeuangan'])->name('admin.keuangan');
    Route::get('/admin/keuangan/export', [KeuanganController::class, 'exportKeuanganPDF'])->name('admin.keuangan.export');

    // Konfirmasi Penukaran Poin
    Route::get('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'showKonfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin');
    Route::post('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'konfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin.submit');

    // Manajemen Admin
    Route::get('/admin/data-admin', [AdminController::class, 'dataAdmin'])->name('admin.data-admin');
    Route::get('/admin/tambah-admin', [AdminController::class, 'createAdmin'])->name('admin.create');
    Route::post('/admin/tambah-admin', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::put('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');

    //Menampilkan data member
    Route::get('/admin/data-member', [AdminController::class, 'dataMember'])->name('admin.data-member');
    // Pemesanan oleh Admin
    Route::get('/admin/pemesanan/create', [AdminController::class, 'createPemesanan'])->name('admin.pemesanan.create');
    Route::post('/admin/pemesanan/store', [AdminController::class, 'storePemesanan'])->name('admin.pemesanan.store');
    Route::get('/admin/pemesanan/{id}/edit', [AdminController::class, 'editPemesanan'])->name('admin.editPemesanan');
    Route::post('/admin/pemesanan/{id}/update', [AdminController::class, 'updatePemesanan'])->name('admin.updatePemesanan');
    Route::delete('/admin/pemesanan/{id}/hapus', [AdminController::class, 'hapusPemesanan'])->name('admin.pemesanan.hapus');


    // Pengajuan Refund
    Route::get('/admin/refund', [RefundAdminController::class, 'index'])->name('admin.refunds.index');
    Route::get('/refund/{id}', [RefundAdminController::class, 'show'])->name('admin.refunds.show');
    Route::post('/refund/{id}/approve', [RefundAdminController::class, 'approve'])->name('admin.refunds.approve');
    Route::post('/refund/{id}/reject', [RefundAdminController::class, 'reject'])->name('admin.refunds.reject');
    // CRUD Informasi (Admin)
    Route::get('/admin/information', [InformationController::class, 'index'])->name('admin.information.index');
    Route::get('/admin/information/create', [InformationController::class, 'create'])->name('admin.information.create');
    Route::post('/admin/information', [InformationController::class, 'store'])->name('admin.information.store');
    Route::get('/admin/information/{information}/edit', [InformationController::class, 'edit'])->name('admin.information.edit');
    Route::put('/admin/information/{information}', [InformationController::class, 'update'])->name('admin.information.update');
    Route::delete('/admin/information/{information}', [InformationController::class, 'destroy'])->name('admin.information.destroy');
});




// ===============================
// Rute Auth
// ===============================
require __DIR__ . '/auth.php';
