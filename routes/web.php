<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PotonganKeterlambatanController;
use App\Http\Controllers\TunjanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route resource untuk Gaji, Potongan Keterlambatan, dan Tunjangan
Route::middleware('auth')->group(function () {
    Route::resource('gaji', GajiController::class);
    Route::resource('potongan', PotonganKeterlambatanController::class);
    Route::resource('tunjangan', TunjanganController::class);
});

// Admin (A) bisa edit Pegawai
Route::middleware(['auth', 'role:A'])->group(function () {
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
});

// Admin (A) dan Tamu (T) hanya bisa melihat Pegawai
Route::middleware(['auth', 'role:A,T'])->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
});

// Route untuk testing role

require __DIR__.'/auth.php';
