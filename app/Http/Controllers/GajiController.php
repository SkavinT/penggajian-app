<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Tunjangan;
use App\Models\PotonganKeterlambatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $query = Gaji::with('pegawai');

        // Filter nama pegawai hanya untuk admin
        if (Auth::user()->role === 'a' && $request->filled('nama_pegawai')) {
            $nama = $request->nama_pegawai;
            $query->whereHas('pegawai', function($q) use ($nama) {
                $q->where('nama', 'like', '%' . $nama . '%');
            });
        }

        // Untuk user biasa, selalu batasi ke namanya sendiri
        if (Auth::user()->role !== 'a') {
            $nama = Auth::user()->name;
            $query->whereHas('pegawai', function($q) use ($nama) {
                $q->whereRaw('LOWER(nama) = ?', [strtolower($nama)]);
            });
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereRaw("RIGHT(bulan,2) = ?", [$request->bulan]);
        }
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereRaw("LEFT(bulan,4) = ?", [$request->tahun]);
        }

        $gajis = $query->paginate(10);

        return view('gaji.index', compact('gajis'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        return view('gaji.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        // format angka
        $request->merge([
            'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
            'tunjangan'  => str_replace('.', '', $request->tunjangan),
            'potongan'   => str_replace('.', '', $request->potongan),
            // set tanggal hari ini
            'tanggal'    => now()->format('Y-m-d'),
        ]);

        $request->validate([
            'pegawai_id' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan'  => 'nullable|numeric',
            'potongan'   => 'nullable|numeric',
            'bulan'      => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string',
            'tanggal'    => 'required|date',
        ]);

        $total_gaji = ($request->gaji_pokok ?? 0)
                    + ($request->tunjangan  ?? 0)
                    - ($request->potongan   ?? 0);

        $data = $request->all();
        $data['total_gaji'] = $total_gaji;

        Gaji::create($data);

        return redirect()->route('gaji.index')
                         ->with('success','Data gaji berhasil ditambahkan.');
    }

    public function edit(Gaji $gaji)
    {
        $pegawais = Pegawai::all();
        $tunjangans = Tunjangan::all();
        $potongans = PotonganKeterlambatan::all();
        return view('gaji.edit', compact('gaji', 'pegawais', 'tunjangans', 'potongans'));
    }

    public function update(Request $request, Gaji $gaji)
    {
        $request->merge([
            'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
            'tunjangan' => str_replace('.', '', $request->tunjangan),
            'potongan' => str_replace('.', '', $request->potongan),
        ]);

        $request->validate([
            'pegawai_id' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
            'bulan' => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string',
        ]);

        $total_gaji = ($request->gaji_pokok ?? 0) + ($request->tunjangan ?? 0) - ($request->potongan ?? 0);

        $data = $request->all();
        $data['total_gaji'] = $total_gaji;

        $gaji->update($data);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diupdate.');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return redirect()->route('gaji.index')->with('success', 'Gaji berhasil dihapus.');
    }

    public function show($id)
    {
        $gaji = Gaji::findOrFail($id);
        return view('gaji.show', compact('gaji'));
    }

    public function exportCsv()
    {
        $filename = 'data_gaji.csv';
        $gajis = \App\Models\Gaji::with('pegawai')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($gajis) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Nama Pegawai', 'Gaji Pokok', 'Tunjangan', 'Potongan', 'Total Gaji', 'Tanggal', 'Keterangan']);
            foreach ($gajis as $i => $gaji) {
                fputcsv($handle, [
                    $i+1,
                    $gaji->pegawai->nama ?? '',
                    $gaji->gaji_pokok,
                    $gaji->tunjangan,
                    $gaji->potongan,
                    $gaji->total_gaji,
                    $gaji->bulan->format('Y-m'),
                    $gaji->keterangan
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // skip header

        while (($row = fgetcsv($handle)) !== false) {
            // Contoh urutan kolom: No, Nama Pegawai, Gaji Pokok, Tunjangan, Potongan, Total Gaji, Tanggal, Keterangan
            // Anda bisa sesuaikan index kolom sesuai file CSV Anda
            $pegawai = \App\Models\Pegawai::where('nama', $row[1])->first();
            if ($pegawai) {
                \App\Models\Gaji::create([
                    'pegawai_id' => $pegawai->id,
                    'gaji_pokok' => $row[2],
                    'tunjangan'  => $row[3],
                    'potongan'   => $row[4],
                    'total_gaji' => $row[5],
                    'bulan'    => $row[6],
                    'keterangan' => $row[7] ?? null,
                ]);
            }
        }
        fclose($handle);

        return redirect()->route('gaji.index')->with('success', 'Import CSV berhasil!');
    }
}
