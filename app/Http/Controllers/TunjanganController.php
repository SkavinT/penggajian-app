<?php   

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Tunjangan;
use Illuminate\Http\Request; // Fixed incorrect import

class TunjanganController extends Controller
{
    // Menampilkan daftar tunjangan beserta pegawai yang berelasi
    public function index()
    {
        $pegawai = Pegawai::with('tunjangans')->get(); // Ambil data pegawai beserta relasi tunjangan
        return view('tunjangan.index', compact('pegawai')); // Kirim data ke view
    }

    // Menampilkan form tambah tunjangan
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('tunjangan.create', compact('pegawais'));
    }

    // Menyimpan data tunjangan baru
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama_tunjangan' => 'required|string|max:255',
            'jumlah_tunjangan' => 'required|numeric',
        ]);

        Tunjangan::create([
            'pegawai_id' => $request->pegawai_id,
            'nama_tunjangan' => $request->nama_tunjangan,
            'jumlah_tunjangan' => $request->jumlah_tunjangan,
        ]);

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil ditambahkan.');
    }

    // Menampilkan detail tunjangan
    public function show($id)
    {
        $tunjangan = Tunjangan::with('pegawai')->findOrFail($id);
        return view('tunjangan.show', compact('tunjangan'));
    }

    // Menampilkan form edit tunjangan
    public function edit($id)
    {
        $tunjangan = Tunjangan::findOrFail($id);
        $pegawais = Pegawai::all();
        return view('tunjangan.edit', compact('tunjangan', 'pegawais'));
    }

    // Mengupdate data tunjangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama_tunjangan' => 'required|string|max:255',
            'jumlah_tunjangan' => 'required|numeric',
        ]);

        $tunjangan = Tunjangan::findOrFail($id);
        $tunjangan->update($request->all());

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil diupdate.');
    }

    // Menghapus data tunjangan
    public function destroy($id)
    {
        $tunjangan = Tunjangan::findOrFail($id);
        $tunjangan->delete();

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan berhasil dihapus.');
    }
}