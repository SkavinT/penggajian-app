<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Gaji;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();
        $totalGaji = Gaji::sum('total_gaji');
        $totalTunjangan = Gaji::sum('tunjangan');
        $totalPotongan = Gaji::sum('potongan'); // Hitung total potongan dari tabel gajis
        $recentPegawais = Pegawai::latest()->take(5)->get(); // Ambil 5 pegawai terbaru

        return view('dashboard', compact('jumlahPegawai', 'totalGaji', 'totalTunjangan', 'totalPotongan', 'recentPegawais'));
    }
}