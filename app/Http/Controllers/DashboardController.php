<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Gaji;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

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
        $totalGajiBulanIni = Gaji::whereMonth('created_at', date('m'))
                                 ->whereYear('created_at', date('Y'))
                                 ->sum('total_gaji');

        $totalPengeluaranSemua = Gaji::sum('total_gaji');

        $recentPegawais = Pegawai::whereMonth('created_at', date('m'))
                                 ->whereYear('created_at', date('Y'))
                                 ->get();
        $lastGajis      = Gaji::with('pegawai')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();

        // 2) Data chart: pengeluaran gaji per bulan
        $gajiPerBulan = Gaji::selectRaw("bulan as bulan, SUM(total_gaji) as total")
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
            $labels[]        = DateTime::createFromFormat('!m', $m)->format('M');
            $gajiValues[]    = $gajiPerBulan[$key]   ?? 0;
            $pegawaiValues[] = $pegawaiPerBulan[$key] ?? 0;
        }

        // Perbaiki pengecekan role agar tidak error jika user belum login
        $user = Auth::user();
        if (!$user || $user->role !== 'a') {
            $pegawaiValues = array_fill(0, 12, 0);
        }

        // Perbaiki orderByDesc pada relasi gajis, gunakan created_at jika bulan tidak ada
        $pegawaiGaji = Pegawai::with(['gajis' => function($q) {
            $q->orderByDesc('created_at');
        }])->get()->map(function($p) {
            return [
                'nama' => $p->nama,
                'total_gaji' => optional($p->gajis->first())->total_gaji ?? 0
            ];
        })->values();

        $showPegawaiChart = $user && $user->role === 'a'; // true hanya untuk admin

        return view('dashboard', compact(
            'totalPegawai',
            'totalGajiBulanIni',
            'totalPengeluaranSemua',
            'recentPegawais',
            'lastGajis',
            'labels',
            'gajiValues',
            'pegawaiValues',
            'showPegawaiChart' // <-- tambahkan ini
        ))->with('pegawaiGaji', $pegawaiGaji);
    }
}