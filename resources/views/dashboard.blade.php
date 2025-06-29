@extends('layouts.app')

@section('content')
<div class="row mb-4">
  <!-- Pegawai Baru Bulan Ini -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
          Pegawai Baru Bulan Ini
        </div>
        <div class="h5 mb-0 font-weight-bold text-gray-800">
          {{ $recentPegawais->count() }}
        </div>
        <div class="mt-2">
          <ul class="list-unstyled mb-0">
            @forelse($recentPegawais as $pegawai)
              <li>• {{ $pegawai->nama }}</li>
            @empty
              <li class="text-muted">Belum ada pegawai baru bulan ini.</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Pegawai -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
            Total Pegawai
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{ $totalPegawai }}
          </div>
        </div>
        <i class="fas fa-users fa-2x text-gray-300"></i>
      </div>
    </div>
  </div>

  <!-- Total Gaji Bulan Ini -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Gaji Bulan Ini
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            Rp {{ number_format($totalGajiBulanIni,0,',','.') }}
          </div>
        </div>
        <i class="fas fa-wallet fa-2x text-gray-300"></i>
      </div>
    </div>
  </div>

  <!-- Total Pengeluaran Gaji Keseluruhan -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
            Total Pengeluaran Gaji Keseluruhan
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            Rp {{ number_format($totalPengeluaranSemua, 0, ',', '.') }}
          </div>
        </div>
        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
      </div>
    </div>
  </div>
</div>


<!-- Grafik Gaji Bulan Ini -->
<div class="row mb-4">
  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pengeluaran Gaji Per Bulan</h6>
      </div>
      <div class="card-body">
        <canvas id="gajiChart"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Total Pegawai Per Bulan</h6>
      </div>
      <div class="card-body">
        <canvas id="pegawaiChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- List 5 Transaksi Terakhir -->
<div class="row mb-4">
  <div class="col-lg-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 bg-success text-white">
        <strong>5 Transaksi Gaji Terakhir</strong>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($lastGajis as $g)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $g->pegawai->nama }}<br>
              <small>{{ \Carbon\Carbon::parse($g->bulan.'-01')->translatedFormat('F Y') }}</small>
              <span class="badge badge-success badge-pill">
                Rp {{ number_format($g->total_gaji,0,',','.') }}
              </span>
            </li>
          @empty
            <li class="list-group-item text-center text-muted">
              Belum ada transaksi.
            </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
  
  <!-- Pengumuman -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
          Pengumuman
        </div>
        <div class="small text-gray-800">
          Proses gaji dilakukan setiap tanggal 25. Pastikan absensi & data lengkap!
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart Pengeluaran Gaji
  new Chart(document.getElementById('gajiChart'), {
    type: 'bar',
    data: {
      labels: @json($labels),
      datasets: [{
        label: 'Rp Total Gaji',
        data: @json($gajiValues),
        backgroundColor: 'rgba(78,115,223,0.5)',
        borderColor: 'rgba(78,115,223,1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Chart Total Pegawai (rentang 1–20)
  new Chart(document.getElementById('pegawaiChart'), {
    type: 'line',
    data: {
      labels: @json($labels),
      datasets: [{
        label: 'Jumlah Pegawai',
        data: @json($pegawaiValues),
        backgroundColor: 'rgba(28,200,138,0.2)',
        borderColor: 'rgba(28,200,138,1)',
        fill: true
      }]
    },
    options: {
      scales: {
        y: {
          min: 1,
          max: 40,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
</script>
@endpush
