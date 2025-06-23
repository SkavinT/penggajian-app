<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Gaji;
use Illuminate\Http\Request;
use DateTime;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1) Ringkasan singkat
        $totalPegawai      = Pegawai::count();
        $totalGajiBulanIni = Gaji::where('bulan', date('Y-m'))->sum('total_gaji');
        // Tambahkan total pengeluaran keseluruhan
        $totalPengeluaranSemua = Gaji::sum('total_gaji');

        $recentPegawais    = Pegawai::whereMonth('created_at', date('m'))
                                     ->whereYear('created_at', date('Y'))
                                     ->get();
        $lastGajis         = Gaji::with('pegawai')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        // 2) Data chart: pengeluaran gaji per bulan
        $gajiPerBulan = Gaji::selectRaw("bulan, SUM(total_gaji) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total','bulan')
            ->toArray();

        // 3) Data chart: total pegawai per bulan
        $pegawaiPerBulan = Pegawai::selectRaw("DATE_FORMAT(created_at,'%Y-%m') as bulan, COUNT(*) as total")
            ->groupByRaw("DATE_FORMAT(created_at,'%Y-%m')")
            ->orderBy('bulan')
            ->pluck('total','bulan')
            ->toArray();

        // 4) Build labels & values untuk 12 bulan
        $year         = date('Y');
        $labels       = $gajiValues = $pegawaiValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $key = $year . '-' . str_pad($m,2,'0',STR_PAD_LEFT);
            // untuk tampilan X axis: Jan, Feb, dst.
            $labels[]        = DateTime::createFromFormat('!m', $m)->format('M');
            $gajiValues[]    = $gajiPerBulan[$key]   ?? 0;
            $pegawaiValues[] = $pegawaiPerBulan[$key] ?? 0;
        }

        return view('dashboard', compact(
            'totalPegawai',
            'totalGajiBulanIni',
            'totalPengeluaranSemua',  // <-- baru
            'recentPegawais',
            'lastGajis',
            'labels',
            'gajiValues',
            'pegawaiValues'
        ));
    }
}