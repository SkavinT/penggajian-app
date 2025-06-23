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

// Semua user yang sudah login bisa melihat dan admin bisa mengelola data pegawai & gaji
Route::middleware(['auth'])->group(function () {
    // Route export-csv HARUS di atas resource!
    Route::get('/gaji/export-csv', [GajiController::class, 'exportCsv'])->name('gaji.export.csv');
    Route::post('/gaji/import-csv', [GajiController::class, 'importCsv'])->name('gaji.import.csv');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('gaji', GajiController::class);
    Route::resource('potongan-keterlambatan', PotonganKeterlambatanController::class)->only(['index', 'show']);
    Route::resource('tunjangan', TunjanganController::class)->only(['index', 'show']);
});

// Hanya admin (role 'a') yang bisa melakukan create, edit, update, delete pada resource selain pegawai & gaji
Route::middleware(['auth'])->group(function () {
    Route::resource('potongan-keterlambatan', PotonganKeterlambatanController::class)->except(['index', 'show'])
        ->middleware('can:isAdmin,' . \App\Models\User::class);
    Route::resource('tunjangan', TunjanganController::class)->except(['index', 'show'])
        ->middleware('can:isAdmin,' . \App\Models\User::class);
});

require __DIR__.'/auth.php';
