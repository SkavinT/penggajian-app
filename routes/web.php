<?php

use App\Http\Controllers\ProfileController;
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

// Route resource untuk Pegawai, Gaji, Potongan Keterlambatan, dan Tunjangan
Route::middleware('auth')->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('gaji', GajiController::class);
    Route::resource('potongan', PotonganKeterlambatanController::class);
    Route::resource('tunjangan', TunjanganController::class);
});

require __DIR__.'/auth.php';
