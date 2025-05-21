<!-- filepath: resources/views/tunjangan/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Tunjangan Pegawai</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Keterangan</th>
                <th>Jumlah Tunjangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jabatan }}</td>
                <td>
                    @foreach($data->tunjangans as $tunjangan)
                        {{ $tunjangan->keterangan ?? '-' }}<br>
                    @endforeach
                </td>
                <td>
                    Rp {{ number_format($data->tunjangans->sum('tunjangan'), 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<?php
use App\Models\Pegawai;

class TunjanganController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('tunjangans')->get();
        return view('tunjangan.index', compact('pegawai'));
    }
}
?>