<!-- filepath: d:\Materi Kuliah\KP\KP_WEB\penggajian-app\resources\views\gaji\edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="my-4">Edit Data Gaji</h1>

  <form method="POST" action="{{ route('gaji.update', $gaji->id) }}" id="gaji-form">
    @csrf
    @method('PUT')

    {{-- Pilih Pegawai --}}
    <div class="form-group mb-3">
      <label for="pegawai_id">Pegawai</label>
      <select id="pegawai_id" name="pegawai_id"
              class="form-control @error('pegawai_id') is-invalid @enderror" required>
        <option value="" disabled>Pilih Pegawai</option>
        @foreach($pegawais as $pegawai)
          <option value="{{ $pegawai->id }}"
                  data-gaji="{{ $pegawai->gaji_pokok }}"
                  {{ old('pegawai_id', $gaji->pegawai_id)==$pegawai->id ? 'selected' : '' }}>
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
             value="{{ old('gaji_pokok', number_format($gaji->gaji_pokok,0,'','')) }}" required>
      @error('gaji_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Tunjangan --}}
    <div class="form-group mb-3">
      <label for="tunjangan">Tunjangan</label>
      <input id="tunjangan" name="tunjangan" type="text"
             class="form-control currency @error('tunjangan') is-invalid @enderror"
             value="{{ old('tunjangan', number_format($gaji->tunjangan ?? 0,0,'','')) }}">
      @error('tunjangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Potongan --}}
    <div class="form-group mb-3">
      <label for="potongan">Potongan</label>
      <input id="potongan" name="potongan" type="text"
             class="form-control currency @error('potongan') is-invalid @enderror"
             value="{{ old('potongan', number_format($gaji->potongan ?? 0,0,'','')) }}">
      @error('potongan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Bulan --}}
    <div class="form-group mb-3">
      <label for="bulan">Bulan</label>
      <input id="bulan" name="bulan" type="month"
             class="form-control @error('bulan') is-invalid @enderror"
             value="{{ old('bulan', $gaji->bulan) }}" required>
      @error('bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Keterangan --}}
    <div class="form-group mb-3">
      <label for="keterangan">Keterangan</label>
      <textarea id="keterangan" name="keterangan" rows="3"
                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $gaji->keterangan) }}</textarea>
      @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Gaji</button>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const formatCurrency = v => v.replace(/\D/g,'')
                                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

  document.querySelectorAll('.currency').forEach(input => {
    // inisialisasi format tampilan
    input.value = formatCurrency(input.value);

    input.addEventListener('input', () => {
      input.value = formatCurrency(input.value);
    });
  });

  // auto-fill gaji_pokok saat pegawai dipilih
  document.getElementById('pegawai_id').addEventListener('change', function() {
    let gaji = this.selectedOptions[0].dataset.gaji || 0;
    document.getElementById('gaji_pokok').value = formatCurrency(gaji);
  });

  // strip titik sebelum submit
  document.getElementById('gaji-form').addEventListener('submit', () => {
    document.querySelectorAll('.currency').forEach(input => {
      input.value = input.value.replace(/\./g,'');
    });
  });
});
</script>
@endpush