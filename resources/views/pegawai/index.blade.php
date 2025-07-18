@extends('layouts.app')

@section('content')
<div id="main-content" class="container-fluid" style="margin-left:0; padding: 10px;">
  <h1 class="mb-4">Data Pegawai</h1>

  <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
    @if(auth()->user() && auth()->user()->role === 'a')
      <a href="{{ route('pegawai.create') }}"
         class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Pegawai
      </a>
    @endif
    <a href="{{ route('pegawai.export.xls') }}"
       class="btn btn-success d-flex align-items-center">
      <i class="bi bi-file-earmark-arrow-down me-1"></i>
      Export Excel
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th><th>NIP</th><th>Nama</th><th>Email</th>
          <th>Jabatan</th><th>Gaji Pokok</th><th>Alamat</th>
          <th>Telepon</th><th>Aksi</th>
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
            @can('update', $pegawai)
              <a href="{{ route('pegawai.edit', $pegawai) }}"
                 class="btn btn-sm btn-primary">Edit</a>
            @endcan
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
