@extends('layouts.app')

@section('content')
    <h1>Data Pegawai</h1>

    @if(Auth::user()->role === 'A')
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>
    @endif

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
@endsection
