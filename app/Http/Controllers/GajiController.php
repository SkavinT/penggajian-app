<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Tunjangan;
use App\Models\PotonganKeterlambatan;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::with('pegawai')->paginate(10);
        return view('gaji.index', compact('gajis'));
    }

    public function create()
    {
        $pegawais = Pegawai::all(); // Ambil semua data pegawai
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
            'bulan'       => 'required|string',
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
            'bulan'       => $request->bulan,
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
}
