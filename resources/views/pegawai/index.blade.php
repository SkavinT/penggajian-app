@extends('layouts.app')

@section('content')
    <h1>Data Pegawai</h1>
    {{-- Debug --}}
    @can('create', App\Models\Pegawai::class)
        <div class="mb-3">
            <a href="{{ route('pegawai.create') }}" class="btn btn-primary">Tambah Data Pegawai</a>
        </div>
    @endcan

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $i => $pegawai)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $pegawai->nip }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->jabatan }}</td>
                    <td>{{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>{{ $pegawai->telepon }}</td>
                    @can('update', $pegawai)
                    <td>
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
