@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pegawai</h1>

    <form action="{{ route('pegawai.store') }}" method="POST" id="pegawai-form">
        @csrf

        {{-- NIP --}}
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" required>
        </div>

        {{-- Nama --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pegawai</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        {{-- Jabatan --}}
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" required>
        </div>

        {{-- Gaji Pokok --}}
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input id="gaji_pokok"
                   name="gaji_pokok"
                   type="text"
                   class="form-control currency @error('gaji_pokok') is-invalid @enderror"
                   value="{{ old('gaji_pokok') }}" required>
            @error('gaji_pokok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>

        {{-- Telepon --}}
        <div class="mb-3">
            <label for="telepon" class="form-label">No Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // format input as currency with dot separator
    const formatCurrency = v => v.replace(/\D/g, '')
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    document.querySelectorAll('.currency').forEach(input => {
        input.addEventListener('input', e => {
            e.target.value = formatCurrency(e.target.value);
        });
    });

    // strip dots before form submit
    document.getElementById('pegawai-form').addEventListener('submit', () => {
        document.querySelectorAll('.currency').forEach(input => {
            input.value = input.value.replace(/\./g, '');
        });
    });
});
</script>
@endpush
