<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Log; // Import Log facade

use Illuminate\Routing\Controller;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is authenticated
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'a') { // Check if user is authenticated and has the correct role
                abort(403, 'Akses hanya untuk admin.');
            }
            return $next($request);
        });
    }

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
    public function exportXls()
    {
        $pegawais = Pegawai::all();

        $headers = [
            "Content-Type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=pegawai.xls",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $output = '<table border="1">';
        $output .= '
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Alamat</th>
                <th>Telepon</th>
            </tr>';
        foreach ($pegawais as $p) {
            $output .= '<tr>
                <td>' . $p->nip . '</td>
                <td>' . $p->nama . '</td>
                <td>' . $p->email . '</td>
                <td>' . $p->jabatan . '</td>
                <td>' . $p->gaji_pokok . '</td>
                <td>' . $p->alamat . '</td>
                <td>' . $p->telepon . '</td>
            </tr>';
        }
        $output .= '</table>';

        return response($output, 200, $headers);
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
                if (count($row) < 7) {
                    continue;
                }
                Pegawai::create([
                    'nip'        => $row[0],
                    'nama'       => $row[1],
                    'email'      => $row[2],
                    'jabatan'    => $row[3],
                    'gaji_pokok' => $row[4],
                    'alamat'     => $row[5],
                    'telepon'    => $row[6],
                ]);
            }
            fclose($handle);
        }
        return back()->with('success','Data pegawai berhasil di‐import.');
    }
}
