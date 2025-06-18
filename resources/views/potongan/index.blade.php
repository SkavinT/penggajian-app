@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Potongan Keterlambatan Pegawai</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Keterangan</th>
                <th>Potongan Gaji</th>
                @can('isAdmin', auth()->user())
                    <th>Aksi</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jabatan }}</td>
                <td>
                    @foreach($data->gajis as $gaji)
                        {{ $gaji->keterangan ?? '-' }}<br>
                    @endforeach
                </td>
                <td>Rp {{ number_format($data->gajis->sum('potongan'), 0, ',', '.') }}</td>
                @can('isAdmin', auth()->user())
                    <td>
                        <a href="{{ route('potongan.edit', $data->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection