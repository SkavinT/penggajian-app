<?php

namespace App\Http\Controllers;

use App\Models\PotonganKeterlambatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PotonganKeterlambatanController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('potongans')->get(); // Ambil semua data pegawai beserta relasi potongan
        return view('potongan.index', compact('pegawai'));
    }

    public function create()
    {
        return view('potongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'keterangan' => 'required|string',
            'jumlah' => 'required|integer',
        ]);

        PotonganKeterlambatan::create([
            'pegawai_id' => $request->pegawai_id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('potongan.index')->with('success', 'Data potongan berhasil ditambahkan.');
    }

    public function edit(PotonganKeterlambatan $potongan)
    {
        return view('potongan.edit', compact('potongan'));
    }

    public function update(Request $request, PotonganKeterlambatan $potongan)
    {
        $request->validate([
            'jenis' => 'required',
            'biaya' => 'required|integer',
        ]);

        $potongan->update($request->all());
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil diupdate.');
    }

    public function destroy(PotonganKeterlambatan $potongan)
    {
        $potongan->delete();
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil dihapus.');
    }
}
