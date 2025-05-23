<!-- filepath: d:\Materi Kuliah\KP\KP_WEB\penggajian-app\resources\views\gaji\create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Tambah Data Gaji</h1>
    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf
        <!-- Pilih Pegawai -->
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Pegawai</label>
            <select name="pegawai_id" id="pegawai_id" class="form-control" required>
                <option value="" disabled selected>Pilih Pegawai</option>
                @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Pilih pegawai yang akan menerima gaji.</small>
        </div>
        <!-- Gaji Pokok -->
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
            <small class="form-text text-muted">Masukkan gaji pokok pegawai sesuai data model.</small>
        </div>

        <!-- Tunjangan -->
        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="number" name="tunjangan" id="tunjangan" class="form-control">
            <small class="form-text text-muted">Masukkan tunjangan pegawai (opsional).</small>
        </div>

        <!-- Potongan -->
        <div class="mb-3">
            <label for="potongan" class="form-label">Potongan</label>
            <input type="number" name="potongan" id="potongan" class="form-control">
            <small class="form-text text-muted">Masukkan jumlah potongan gaji (opsional).</small>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
            <small class="form-text text-muted">Masukkan keterangan tambahan (opsional).</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <script>
        // Hitung total gaji otomatis
        document.getElementById('gaji_pokok').addEventListener('input', calculateTotal);
        document.getElementById('tunjangan').addEventListener('input', calculateTotal);
        document.getElementById('potongan').addEventListener('input', calculateTotal);

        function calculateTotal() {
            const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
            const tunjangan = parseInt(document.getElementById('tunjangan').value) || 0;
            const potongan = parseInt(document.getElementById('potongan').value) || 0;

            const totalGaji = gajiPokok + tunjangan - potongan;
            console.log('Total Gaji:', totalGaji); // Debugging
        }
    </script>
@endsection