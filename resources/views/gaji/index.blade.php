<!-- resources/views/gaji/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Data Gaji</h1>

    <!-- Tombol Tambah Data Gaji -->
    <div class="mb-3">
        <a href="{{ route('gaji.create') }}" class="btn btn-primary">Tambah Data Gaji</a>
    </div>

    <!-- Tabel Menampilkan Data Gaji Responsive -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Potongan</th>
                    <th>Total Gaji</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>    <!-- kolom tanggal -->
                    <th>Bulan</th>      <!-- kolom bulan -->
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gajis as $index => $gaji)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->pegawai->nama }}</td>
                    <td>{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->tunjangan ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->potongan ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                    <td>{{ $gaji->keterangan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal)->format('d-m-Y') }}</td>  <!-- tampilkan tanggal -->
                    <td>{{ $gaji->bulan }}</td>                                          <!-- tampilkan bulan -->
                    <td>
                        @if(Auth::user()->role === 'A')
                            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination (jika diperlukan) -->
    {{ $gajis->links() }}

</div>
@endsection
