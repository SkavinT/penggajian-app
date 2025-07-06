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
        $query = Gaji::with('pegawai');

        if ($request->filled('nama')) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        $gajis = $query->paginate(10);

        // 1) Ringkasan singkat
        $totalPegawai = Pegawai::count();
        // dulu: pakai kolom `bulan` yang tidak ada
        // $totalGajiBulanIni = Gaji::where('bulan', date('Y-m'))->sum('total_gaji');
        // baru: filter berdasarkan created_at bulan & tahun sekarang
        $totalGajiBulanIni = Gaji::whereMonth('created_at', date('m'))
                                 ->whereYear('created_at', date('Y'))
                                 ->sum('total_gaji');

        // Tambahkan total pengeluaran keseluruhan
        $totalPengeluaranSemua = Gaji::sum('total_gaji');

        $recentPegawais = Pegawai::whereMonth('created_at', date('m'))
                                 ->whereYear('created_at', date('Y'))
                                 ->get();
        $lastGajis      = Gaji::with('pegawai')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();

        // 2) Data chart: pengeluaran gaji per bulan
        $gajiPerBulan = Gaji::selectRaw("LEFT(bulan,7) as bulan, SUM(total_gaji) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Buat array label (bulan) dan value (total gaji)
        $labels = $gajiPerBulan->pluck('bulan')->map(function($b) {
            // Format ke nama bulan Indonesia, misal: '2025-08' => 'Aug 2025'
            return \Carbon\Carbon::createFromFormat('Y-m', $b)->translatedFormat('M Y');
        });
        $gajiValues = $gajiPerBulan->pluck('total');

        // 3) Data chart: total pegawai per bulan
        $pegawaiPerBulan = Pegawai::selectRaw("DATE_FORMAT(created_at,'%Y-%m') as bulan, COUNT(*) as total")
            ->groupByRaw("DATE_FORMAT(created_at,'%Y-%m')")
            ->orderBy('bulan')
            ->pluck('total','bulan')
            ->toArray();

        // 4) Build labels & values untuk 12 bulan
        $year         = date('Y');
        $pegawaiValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $key = $year . '-' . str_pad($m,2,'0',STR_PAD_LEFT);
            // untuk tampilan X axis: Jan, Feb, dst.
            $pegawaiValues[] = $pegawaiPerBulan[$key] ?? 0;
        }

        $pegawaiGaji = Pegawai::with(['gajis' => function($q) {
            $q->orderByDesc('bulan');
        }])->get()->map(function($p) {
            return [
                'nama' => $p->nama,
                'total_gaji' => optional($p->gajis->first())->total_gaji ?? 0
            ];
        })->values();

        return view('dashboard', compact(
            'totalPegawai',
            'totalGajiBulanIni',
            'totalPengeluaranSemua',
            'recentPegawais',
            'lastGajis',
            'labels',
            'gajiValues',
            'pegawaiValues'
        ))->with('pegawaiGaji', $pegawaiGaji);
    }
}