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

    {{-- Tunjangan Transport --}}
    <div class="form-group mb-3">
      <label for="tunjangan_transport">Tunjangan Transport</label>
      <input id="tunjangan_transport" name="tunjangan_transport" type="text"
             class="form-control currency @error('tunjangan_transport') is-invalid @enderror"
             value="{{ old('tunjangan_transport', number_format($gaji->tunjangan_transport ?? 0,0,'','')) }}" required>
      @error('tunjangan_transport')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Tunjangan Makan --}}
    <div class="form-group mb-3">
      <label for="tunjangan_makan">Tunjangan Makan</label>
      <input id="tunjangan_makan" name="tunjangan_makan" type="text"
             class="form-control currency @error('tunjangan_makan') is-invalid @enderror"
             value="{{ old('tunjangan_makan', number_format($gaji->tunjangan_makan ?? 0,0,'','')) }}" required>
      @error('tunjangan_makan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Tunjangan (otomatis, readonly) --}}
    <div class="form-group mb-3">
      <label for="tunjangan">Tunjangan</label>
      <input id="tunjangan" name="tunjangan" type="text"
             class="form-control currency @error('tunjangan') is-invalid @enderror"
             value="{{ old('tunjangan', number_format($gaji->tunjangan ?? 0,0,'','')) }}" readonly>
      @error('tunjangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Potongan Pinjaman --}}
    <div class="form-group mb-3">
      <label for="potongan_pinjaman">Potongan Pinjaman</label>
      <input id="potongan_pinjaman" name="potongan_pinjaman" type="text"
             class="form-control currency @error('potongan_pinjaman') is-invalid @enderror"
             value="{{ old('potongan_pinjaman', number_format($gaji->potongan_pinjaman ?? 0,0,'','')) }}" required>
      @error('potongan_pinjaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Potongan Keterlambatan --}}
    <div class="form-group mb-3">
      <label for="potongan_keterlambatan">Potongan Keterlambatan</label>
      <input id="potongan_keterlambatan" name="potongan_keterlambatan" type="text"
             class="form-control currency @error('potongan_keterlambatan') is-invalid @enderror"
             value="{{ old('potongan_keterlambatan', number_format($gaji->potongan_keterlambatan ?? 0,0,'','')) }}" required>
      @error('potongan_keterlambatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Potongan (otomatis, readonly) --}}
    <div class="form-group mb-3">
      <label for="potongan">Potongan</label>
      <input id="potongan" name="potongan" type="text"
             class="form-control currency @error('potongan') is-invalid @enderror"
             value="{{ old('potongan', number_format($gaji->potongan ?? 0,0,'','')) }}" readonly>
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

  function getInt(val) {
    return parseInt(val.replace(/\./g, '')) || 0;
  }

  function updateTunjangan() {
    const transport = getInt(document.getElementById('tunjangan_transport').value);
    const makan = getInt(document.getElementById('tunjangan_makan').value);
    document.getElementById('tunjangan').value = formatCurrency((transport + makan).toString());
  }

  function updatePotongan() {
    const pinjaman = getInt(document.getElementById('potongan_pinjaman').value);
    const keterlambatan = getInt(document.getElementById('potongan_keterlambatan').value);
    document.getElementById('potongan').value = formatCurrency((pinjaman + keterlambatan).toString());
  }

  document.querySelectorAll('.currency').forEach(input => {
    input.value = formatCurrency(input.value);
    input.addEventListener('input', () => {
      input.value = formatCurrency(input.value);
      updateTunjangan();
      updatePotongan();
    });
  });

  document.getElementById('pegawai_id').addEventListener('change', function() {
    let gaji = this.selectedOptions[0].dataset.gaji || 0;
    document.getElementById('gaji_pokok').value = formatCurrency(gaji);
  });

  // trigger update saat load
  updateTunjangan();
  updatePotongan();

  document.getElementById('gaji-form').addEventListener('submit', () => {
    document.querySelectorAll('.currency').forEach(input => {
      input.value = input.value.replace(/\./g,'');
    });
  });
});
</script>
@endpush