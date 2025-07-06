@extends('layouts.app')

@section('content')
<h1>Data Pegawai</h1>

<div class="d-flex mb-3">
  {{-- Tombol Tambah --}}
  @can('create', App\Models\Pegawai::class)
    <a href="{{ route('pegawai.create') }}" 
       class="btn btn-primary me-2">
      Tambah Pegawai
    </a>
  @endcan

  {{-- Tombol Export CSV --}}
  @can('export', App\Models\Pegawai::class)
    <a href="{{ route('pegawai.export.csv') }}" 
       class="btn btn-success me-2">
      Export CSV
    </a>
  @endcan

  {{-- Form Import CSV --}}
  @can('import', App\Models\Pegawai::class)
    <form action="{{ route('pegawai.import.csv') }}"
          method="POST"
          enctype="multipart/form-data"
          class="d-flex">
      @csrf
      <input type="file"
             name="file"
             accept=".csv"
             class="form-control me-2"
             required>
      <button type="submit"
              class="btn btn-primary">
        Import CSV
      </button>
    </form>
  @endcan
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
          @can('delete', $pegawai)
            <form action="{{ route('pegawai.destroy', $pegawai) }}"
                  method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit"
                      class="btn btn-sm btn-danger"
                      onclick="return confirm('Yakin hapus?')">
                Hapus
              </button>
            </form>
          @endcan
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
