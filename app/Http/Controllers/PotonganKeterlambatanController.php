<?php

namespace App\Http\Controllers;

use App\Models\PotonganKeterlambatan;
use Illuminate\Http\Request;

class PotonganKeterlambatanController extends Controller
{
    public function index()
    {
        $potongans = PotonganKeterlambatan::all();
        return view('potongan.index', compact('potongans'));
    }

    public function create()
    {
        return view('potongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'biaya' => 'required|integer',
        ]);

        PotonganKeterlambatan::create($request->all());
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil ditambahkan.');
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
