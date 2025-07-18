<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Tunjangan;
use App\Models\PotonganKeterlambatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $query = Gaji::with('pegawai');

        // Filter nama pegawai hanya untuk admin
        if (Auth::user()->role === 'a' && $request->filled('nama_pegawai')) {
            $nama = $request->nama_pegawai;
            $query->whereHas('pegawai', function ($q) use ($nama) {
                $q->where('nama', 'like', '%' . $nama . '%');
            });
        }

        // Untuk user biasa, selalu batasi ke namanya sendiri
        if (Auth::user()->role !== 'a') {
            $nama = Auth::user()->name;
            $query->whereHas('pegawai', function ($q) use ($nama) {
                $q->whereRaw('LOWER(nama) = ?', [strtolower($nama)]);
            });
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereRaw("RIGHT(bulan,2) = ?", [$request->bulan]);
        }
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereRaw("LEFT(bulan,4) = ?", [$request->tahun]);
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
        $data = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'gaji_pokok' => 'required',
            'tunjangan_transport' => 'required',
            'tunjangan_makan' => 'required',
            'potongan_pinjaman' => 'required',
            'potongan_keterlambatan' => 'required',
            'tunjangan' => 'required',
            'potongan' => 'required',
            'bulan' => 'required',
            'keterangan' => 'nullable',
            'total_gaji' => 'required',
        ]);

        // Hilangkan titik ribuan
        foreach ([
            'gaji_pokok','tunjangan_transport','tunjangan_makan',
            'potongan_pinjaman','potongan_keterlambatan',
            'tunjangan','potongan','total_gaji'
        ] as $field) {
            $data[$field] = str_replace('.', '', $data[$field]);
        }

        Gaji::create($data);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil ditambah');
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
        $validated = $request->validate([
            'pegawai_id' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_transport' => 'required|integer',
            'tunjangan_makan' => 'required|integer',
            'potongan_pinjaman' => 'required|integer',
            'potongan_keterlambatan' => 'required|integer',
            'bulan' => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string',
        ]);

        $validated['tunjangan'] = $validated['tunjangan_transport'] + $validated['tunjangan_makan'];
        $validated['potongan'] = $validated['potongan_pinjaman'] + $validated['potongan_keterlambatan'];

        $gaji->update($validated);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diupdate.');
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

    public function exportExcel()
    {
        $gajis = Gaji::with('pegawai')->get();

        $headers = [
            "Content-Type"        => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=data_gaji.xls",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $output = '<table border="1">';
        $output .= '
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Bulan</th>
                <th>Keterangan</th>
            </tr>';
        $i = 1;
        foreach ($gajis as $gaji) {
            $output .= '<tr>
                <td>' . $i++ . '</td>
                <td>' . ($gaji->pegawai->nama ?? '') . '</td>
                <td>' . $gaji->gaji_pokok . '</td>
                <td>' . $gaji->tunjangan . '</td>
                <td>' . $gaji->potongan . '</td>
                <td>' . $gaji->total_gaji . '</td>
                <td>' . $gaji->bulan . '</td>
                <td>' . $gaji->keterangan . '</td>
            </tr>';
        }
        $output .= '</table>';

        return response($output, 200, $headers);
    }
}
