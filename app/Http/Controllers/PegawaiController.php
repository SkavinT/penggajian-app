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
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }
    public function exportCsv()
    {
        $pegawais = Pegawai::all();
        $csv  = "nip,nama,email,jabatan,gaji_pokok,alamat,telepon\n";
        foreach ($pegawais as $p) {
            $csv .= implode(',', [
                $p->nip,
                $p->nama,
                $p->email,
                $p->jabatan,
                $p->gaji_pokok,
                "\"{$p->alamat}\"",
                $p->telepon,
            ]) . "\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=\"pegawai.csv\"',
        ]);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);
        $path = $request->file('file')->getRealPath();
        if (($handle = fopen($path, 'r')) !== false) {
            // skip header
            fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                Pegawai::updateOrCreate(
                    ['nip' => $row[0]],
                    [
                        'nama'       => $row[1],
                        'email'      => $row[2],
                        'jabatan'    => $row[3],
                        'gaji_pokok' => $row[4],
                        'alamat'     => $row[5],
                        'telepon'    => $row[6],
                    ]
                );
            }
            fclose($handle);
        }
        return back()->with('success','Data pegawai berhasil di‐import.');
    }
}
