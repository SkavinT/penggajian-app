<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PotonganKeterlambatanController;
use App\Http\Controllers\TunjanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // ← Tambahkan ini

Route::get('/', function () {
     return view('welcome');
});

// Ganti closure view dengan controller agar variabel dikirim
Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

// Semua user yang sudah login bisa melihat dan admin bisa mengelola data pegawai & gaji
Route::middleware(['auth'])->group(function () {
     // export/import CSV harus di atas resource
     Route::get('/gaji/export-xls', [GajiController::class, 'exportExcel'])->name('gaji.export.xls');

     Route::get('/pegawai/export-xls', [PegawaiController::class, 'exportXls'])
          ->middleware('auth')
          ->name('pegawai.export.xls');


     Route::resource('pegawai', PegawaiController::class);
     Route::resource('gaji', GajiController::class);
     Route::resource('potongan-keterlambatan', PotonganKeterlambatanController::class)->only(['index', 'show']);
     Route::resource('tunjangan', TunjanganController::class)->only(['index', 'show']);
});

// Hanya admin yang bisa create/edit/delete selain pegawai & gaji
Route::middleware(['auth'])->group(function () {
     Route::resource('potongan-keterlambatan', PotonganKeterlambatanController::class)
          ->except(['index', 'show'])
          ->middleware('can:isAdmin,' . \App\Models\User::class);

     Route::resource('tunjangan', TunjanganController::class)
          ->except(['index', 'show'])
          ->middleware('can:isAdmin,' . \App\Models\User::class);
});

// Hanya admin (role 'a') yang bisa akses register karyawan
Route::middleware(['auth'])->group(function () {
    Route::get('/karyawan/register', function () {
        if (Auth::user()->role !== 'a') {
            return response()->view('errors.forbidden', [
                'message' => 'Hanya admin yang dapat mengakses halaman ini.'
            ], 403);
        }
        return app(\App\Http\Controllers\UserController::class)->create();
    })->name('karyawan.register');

    Route::post('/karyawan/register', function (\Illuminate\Http\Request $request) {
        if (Auth::user()->role !== 'a') {
            return response()->view('errors.forbidden', [
                'message' => 'Hanya admin yang dapat mengakses halaman ini.'
            ], 403);
        }
        return app(\App\Http\Controllers\UserController::class)->store($request);
    })->name('karyawan.register.store');
});


require __DIR__ . '/auth.php';
