<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\TunjanganController;
use App\Http\Controllers\PotonganKeterlambatanController;
use Illuminate\Support\Facades\Route;

// Ini buat redirect awal
Route::get('/', fn() => redirect('/dashboard'));

// Ini buat Dashboard
use App\Models\Pegawai;

Route::get('/dashboard', function () {
    $jumlahPegawai = Pegawai::count();
    $totalGaji = Pegawai::sum('gaji_pokok');

    return view('dashboard', compact('jumlahPegawai', 'totalGaji'));
})->name('dashboard');

// Ini resource route ke Controller
Route::resources([
    'pegawai' => PegawaiController::class,
    'gaji' => GajiController::class,
    'tunjangan' => TunjanganController::class,
    'potongan' => PotonganKeterlambatanController::class,
]);
