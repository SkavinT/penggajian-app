<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::all(); // Ambil semua data pegawai
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'jabatan' => 'required',
            'email'   => 'required|email|unique:pegawais,email',
        ]);

        Pegawai::create($request->only([
            'nip','nama','jabatan','gaji_pokok','alamat','telepon','email'
        ]));

        return redirect()->route('pegawai.index')
                         ->with('success','Pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama'    => 'required',
            'jabatan' => 'required',
            'email'   => "required|email|unique:pegawais,email,{$pegawai->id}",
        ]);

        $pegawai->update($request->only([
            'nama','jabatan','gaji_pokok','alamat','telepon','email'
        ]));

        return redirect()->route('pegawai.index')
                         ->with('success','Pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
