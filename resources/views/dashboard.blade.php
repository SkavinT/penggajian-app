@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Card: Jumlah Pegawai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pegawai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPegawai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Total Gaji -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Gaji Dibayarkan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalGaji, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Total Tunjangan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Tunjangan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalTunjangan ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gift fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Total Potongan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Potongan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalPotongan ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-minus-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Grafik atau Tabel Ringkasan -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Ringkasan Pegawai Terbaru</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentPegawais ?? [] as $pegawai)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $pegawai->nama }}
                                <span class="badge badge-primary badge-pill">{{ $pegawai->jabatan }}</span>
                            </li>
                        @endforeach
                        @if(empty($recentPegawais) || count($recentPegawais) == 0)
                            <li class="list-group-item text-center text-muted">Tidak ada data pegawai terbaru.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Info Sistem</strong>
                </div>
                <div class="card-body">
                    <p>Selamat datang di aplikasi penggajian!</p>
                    <ul>
                        <li>Kelola data pegawai, gaji, tunjangan, dan potongan dengan mudah.</li>
                        <li>Gunakan sidebar untuk navigasi ke fitur utama.</li>
                        <li>Dashboard ini menampilkan ringkasan data secara real-time.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
