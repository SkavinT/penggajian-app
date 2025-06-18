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
        $query = Gaji::with('pegawai');

        // Filter berdasarkan bulan dan tahun dari kolom tanggal
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', $request->tahun);
        } elseif ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        } elseif ($request->filled('tahun')) {
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
}
