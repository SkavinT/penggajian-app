<!-- filepath: d:\Materi Kuliah\KP\KP_WEB\penggajian-app\resources\views\gaji\create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Tambah Data Gaji</h1>

    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Pegawai</label>
            <select name="pegawai_id" id="pegawai_id" class="form-control" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="number" name="tunjangan" id="tunjangan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="potongan" class="form-label">Potongan</label>
            <input type="number" name="potongan" id="potongan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection