<?php

namespace App\Http\Controllers;

use App\Models\Tunjangan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class TunjanganController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('tunjangans')->get();
        return view('tunjangan.index', compact('pegawai'));
    }

    public function create()
    {
        return view('tunjangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|integer',
        ]);

        Tunjangan::create($request->all());
        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil ditambahkan.');
    }

    public function edit(Tunjangan $tunjangan)
    {
        return view('tunjangan.edit', compact('tunjangan'));
    }

    public function update(Request $request, Tunjangan $tunjangan)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|integer',
        ]);

        $tunjangan->update($request->all());
        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil diupdate.');
    }

    public function destroy(Tunjangan $tunjangan)
    {
        $tunjangan->delete();
        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil dihapus.');
    }
}
