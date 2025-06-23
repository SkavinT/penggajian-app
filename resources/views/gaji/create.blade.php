<!-- filepath: d:\Materi Kuliah\KP\KP_WEB\penggajian-app\resources\views\gaji\create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="my-4">Tambah Data Gaji</h1>

  <form method="POST" action="{{ route('gaji.store') }}" id="gaji-form">
    @csrf

    {{-- Pilih Pegawai --}}
    <div class="form-group mb-3">
      <label for="pegawai_id">Pegawai</label>
      <select id="pegawai_id" name="pegawai_id"
              class="form-control @error('pegawai_id') is-invalid @enderror" required>
        <option value="" disabled selected>Pilih Pegawai</option>
        @foreach($pegawais as $pegawai)
          <option value="{{ $pegawai->id }}"
                  data-gaji="{{ $pegawai->gaji_pokok }}">
            {{ $pegawai->nama }}
          </option>
        @endforeach
      </select>
      @error('pegawai_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Gaji Pokok --}}
    <div class="form-group mb-3">
      <label for="gaji_pokok">Gaji Pokok</label>
      <input id="gaji_pokok" name="gaji_pokok" type="text"
             class="form-control currency @error('gaji_pokok') is-invalid @enderror"
             value="{{ old('gaji_pokok') }}" required>
      @error('gaji_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Tunjangan --}}
    <div class="form-group mb-3">
      <label for="tunjangan">Tunjangan</label>
      <input id="tunjangan" name="tunjangan" type="text"
             class="form-control currency @error('tunjangan') is-invalid @enderror"
             value="{{ old('tunjangan') }}">
      @error('tunjangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Potongan --}}
    <div class="form-group mb-3">
      <label for="potongan">Potongan</label>
      <input id="potongan" name="potongan" type="text"
             class="form-control currency @error('potongan') is-invalid @enderror"
             value="{{ old('potongan') }}">
      @error('potongan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>


    {{-- Bulan --}}
    <div class="form-group mb-3">
      <label for="bulan">Bulan</label>
      <input type="month" name="bulan" class="form-control"
             value="{{ old('bulan', $gaji->bulan ?? '') }}" required>
    </div>

    {{-- Keterangan --}}
    <div class="form-group mb-3">
      <label for="keterangan">Keterangan</label>
      <textarea id="keterangan" name="keterangan" rows="3"
                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
      @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const formatCurrency = v => v.replace(/\D/g,'')
                                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

  document.querySelectorAll('.currency').forEach(input => {
    input.addEventListener('input', () => {
      input.value = formatCurrency(input.value);
    });
  });

  document.getElementById('pegawai_id').addEventListener('change', function() {
    let gaji = this.selectedOptions[0].dataset.gaji || 0;
    document.getElementById('gaji_pokok').value = formatCurrency(gaji);
  });

  document.getElementById('gaji-form').addEventListener('submit', () => {
    document.querySelectorAll('.currency').forEach(input => {
      input.value = input.value.replace(/\./g,'');
    });
  });
});
</script>
@endpush