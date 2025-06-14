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

// -- ROLE A: full CRUD
Route::middleware(['auth', 'check.role:A'])->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('gaji', GajiController::class);
    Route::resource('potongan-keterlambatan', PotonganKeterlambatanController::class);
    Route::resource('tunjangan', TunjanganController::class);
});

// -- ROLE T: hanya view (index & show)
Route::middleware(['auth', 'check.role:T'])->group(function () {
    // Pegawai
    Route::get('pegawai', [PegawaiController::class, 'index'])
         ->name('pegawai.index');
    Route::get('pegawai/{pegawai}', [PegawaiController::class, 'show'])
         ->name('pegawai.show');

    // Gaji
    Route::get('gaji', [GajiController::class, 'index'])
         ->name('gaji.index');
    Route::get('gaji/{gaji}', [GajiController::class, 'show'])
         ->name('gaji.show');

    // Potongan Keterlambatan
    Route::get('potongan-keterlambatan', [PotonganKeterlambatanController::class, 'index'])
         ->name('potongan-keterlambatan.index');
    Route::get('potongan-keterlambatan/{potongan_keterlambatan}', 
         [PotonganKeterlambatanController::class, 'show'])
         ->name('potongan-keterlambatan.show');

    // Tunjangan
    Route::get('tunjangan', [TunjanganController::class, 'index'])
         ->name('tunjangan.index');
    Route::get('tunjangan/{tunjangan}', [TunjanganController::class, 'show'])
         ->name('tunjangan.show');
});

require __DIR__.'/auth.php';
