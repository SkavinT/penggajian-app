@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Pegawai</h1>

    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-2">
            <label for="nip">NIP</label>
            <input type="text" name="nip" value="{{ $pegawai->nip }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label for="nama">Nama</label>
            <input type="text" name="nama" value="{{ $pegawai->nama }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" value="{{ $pegawai->jabatan }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="text" name="gaji_pokok" value="{{ $pegawai->gaji_pokok }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" value="{{ $pegawai->alamat }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="telepon">Telepon</label>
            <input type="text" name="telepon" value="{{ $pegawai->telepon }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
