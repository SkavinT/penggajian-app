<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Log; // Import Log facade
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PegawaiImport;

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

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $path = $request->file('file')->getRealPath();
        if (($handle = fopen($path, 'r')) !== false) {
            // lewati header
            fgetcsv($handle, 0, ';');

            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                // pastikan ada 8 kolom: No;NIP;Nama;Email;Jabatan;Gaji;Alamat;Telepon
                if (count($row) < 8) continue;

                $nip   = $row[1];
                $email = $row[3];

                // skip jika NIP atau email sudah ada
                $exists = Pegawai::where('nip', $nip)
                            ->orWhere('email', $email)
                            ->exists();
                if ($exists) {
                    continue;
                }

                // simpan baru
                Pegawai::create([
                    'nip'        => $nip,
                    'nama'       => $row[2],
                    'email'      => $email,
                    'jabatan'    => $row[4],
                    'gaji_pokok' => (int) str_replace('.', '', $row[5]),
                    'alamat'     => $row[6],
                    'telepon'    => $row[7],
                ]);
            }
            fclose($handle);
        }

        return redirect()->route('pegawai.index')
                         ->with('success', 'Import CSV berhasil!');
    }
}
