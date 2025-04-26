@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pegawai</h1>

    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pegawai</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">No Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
