<!-- filepath: d:\Materi Kuliah\KP\KP_WEB\penggajian-app\resources\views\gaji\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Data Gaji</h1>

    <form action="{{ route('gaji.update', $gaji->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Pilih Pegawai -->
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Pegawai</label>
            <select name="pegawai_id" id="pegawai_id" class="form-control">
                @foreach($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}" {{ $gaji->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                        {{ $pegawai->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Gaji Pokok -->
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ $gaji->gaji_pokok }}">
        </div>

        <!-- Tunjangan -->
        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="number" name="tunjangan" id="tunjangan" class="form-control" value="{{ $gaji->tunjangan }}">
        </div>

        <!-- Potongan -->
        <div class="mb-3">
            <label for="potongan" class="form-label">Potongan</label>
            <input type="number" name="potongan" id="potongan" class="form-control" value="{{ $gaji->potongan }}">
        </div>

        <!-- Total Gaji -->
        <div class="mb-3">
            <label for="total_gaji" class="form-label">Total Gaji</label>
            <input type="number" name="total_gaji" id="total_gaji" class="form-control" value="{{ $gaji->total_gaji }}" readonly>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $gaji->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection