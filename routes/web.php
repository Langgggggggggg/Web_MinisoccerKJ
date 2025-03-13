<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PemesananController;

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
//untuk admin 
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
require __DIR__ . '/auth.php';
