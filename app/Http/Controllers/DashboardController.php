<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Gaji;

class DashboardController extends Controller
{
    public function index()
    {
        // $jumlahPegawai = Pegawai::count(); // Hitung jumlah pegawai
        $totalGaji = Gaji::sum('total_gaji'); // Hitung total gaji
        $totalTunjangan = Gaji::sum('tunjangan'); // Hitung total tunjangan
        $totalPotongan = Gaji::sum('potongan'); // Hitung total potongan
        $recentPegawais = Pegawai::latest()->take(5)->get(); // Ambil 5 pegawai terbaru

        // Kirim data ke view
        return view('dashboard', [
            // 'jumlahPegawai' => $jumlahPegawai,
            'totalGaji' => $totalGaji,
            'totalTunjangan' => $totalTunjangan,
            'totalPotongan' => $totalPotongan,
            'recentPegawais' => $recentPegawais,
        ]);
    }
}