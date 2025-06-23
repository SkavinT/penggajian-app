<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Tunjangan;
use App\Models\PotonganKeterlambatan;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Gaji::with('pegawai');

        // Filter nama pegawai
        if ($request->filled('nama_pegawai')) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama_pegawai . '%');
            });
        }

        // Filter bulan dan tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
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
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'gaji_pokok' => 'required|integer',
            'tunjangan'   => 'nullable|integer',
            'potongan'    => 'nullable|integer',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string',
        ]);

        $totalGaji = $request->gaji_pokok
            + ($request->tunjangan ?? 0)
            - ($request->potongan ?? 0);

        Gaji::create([
            'pegawai_id'  => $request->pegawai_id,
            'gaji_pokok'  => $request->gaji_pokok,
            'tunjangan'   => $request->tunjangan ?? 0,
            'potongan'    => $request->potongan ?? 0,
            'total_gaji'  => $totalGaji,
            'tanggal'     => $request->tanggal,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('gaji.index')
                         ->with('success', 'Data gaji berhasil ditambahkan.');
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
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'gaji_pokok' => 'required|integer',
            'tunjangan'  => 'nullable|integer',
            'potongan'   => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'tanggal'    => 'required|date',
        ]);

        $totalGaji = $request->gaji_pokok
            + ($request->tunjangan ?? 0)
            - ($request->potongan ?? 0);

        $gaji->update([
            'pegawai_id' => $request->pegawai_id,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan'  => $request->tunjangan ?? 0,
            'potongan'   => $request->potongan ?? 0,
            'total_gaji' => $totalGaji,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('gaji.index')
                         ->with('success', 'Data gaji berhasil diperbarui.');
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
                    $gaji->tanggal,
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
                    'tanggal'    => $row[6],
                    'keterangan' => $row[7] ?? null,
                ]);
            }
        }
        fclose($handle);

        return redirect()->route('gaji.index')->with('success', 'Import CSV berhasil!');
    }
}
