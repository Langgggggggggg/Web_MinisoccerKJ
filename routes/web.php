<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RewardPointController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/detail', [PemesananController::class, 'index'])->name('pemesanan.detail');
    Route::post('/pemesanan/validateSchedule', [PemesananController::class, 'validateSchedule']);
    Route::post('/pemesanan/getSnapToken', [PemesananController::class, 'getSnapToken'])->name('pemesanan.getSnapToken');
});

Route::middleware('auth')->group(function () {
    Route::get('/reward-points', [RewardPointController::class, 'index'])->name('reward.index');
    Route::get('/reward-points/invoice/{id}', [RewardPointController::class, 'invoice'])->name('reward.invoice');
    Route::get('/reward-points/{id}/invoice', [RewardPointController::class, 'downloadInvoice'])->name('reward.download-invoice');
});
Route::middleware('auth')->group(function () {
    // Rute untuk menampilkan data user
    Route::get('/admin/data-user', [AdminController::class, 'dataUser'])->name('user.data-user');
});


//untuk admin 
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Rute untuk menampilkan halaman konfirmasi pelunasan
    Route::get('/admin/konfirmasi-pelunasan', function () {
        return view('admin.konfirmasi-pelunasan');
    })->name('admin.konfirmasi-pelunasan');

    // Rute untuk memproses konfirmasi pelunasan dan reward point
    Route::post('/admin/konfirmasi-pelunasan', [AdminController::class, 'konfirmasiPelunasan'])->name('admin.konfirmasi-pelunasan');
    Route::get('/admin/pemesanan', [AdminController::class, 'dataPemesanan'])->name('admin.data-pemesanan');

    Route::get('/admin/reward-points', [AdminController::class, 'dataRewardPoint'])->name('admin.reward-points');
    Route::get('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'showKonfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin');
    Route::post('/admin/konfirmasi-penukaran-poin', [AdminController::class, 'konfirmasiPenukaranPoin'])->name('admin.konfirmasi-penukaran-poin.submit');

    // Rute untuk menampilkan data admin
    Route::get('/admin/data-admin', [AdminController::class, 'dataAdmin'])->name('admin.data-admin');
    Route::get('/admin/tambah-admin', [AdminController::class, 'createAdmin'])->name('admin.create');
    Route::post('/admin/tambah-admin', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');
});



require __DIR__ . '/auth.php';
