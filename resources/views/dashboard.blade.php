@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Pengumuman -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="alert alert-info shadow">
                <strong>Pengumuman:</strong>
                Proses penggajian bulan ini akan dilakukan pada tanggal 25. Pastikan data absensi sudah lengkap!
            </div>
        </div>
    </div>

    <!-- Pegawai Baru & Ulang Tahun -->
    <div class="row">
        <!-- Pegawai Baru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <strong>Pegawai Baru Bergabung</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentPegawais ?? [] as $pegawai)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $pegawai->nama }}
                                <span class="badge badge-secondary badge-pill">{{ $pegawai->jabatan }}</span>
                            </li>
                        @endforeach
                        @if(empty($recentPegawais) || count($recentPegawais) == 0)
                            <li class="list-group-item text-center text-muted">Belum ada pegawai baru bulan ini.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    <!-- Info Sistem -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <strong>Info Sistem</strong>
                </div>
                <div class="card-body">
                    <p>Selamat datang di aplikasi penggajian!</p>
                    <ul>
                        <li>Kelola data pegawai, absensi, dan penggajian dengan mudah.</li>
                        <li>Gunakan menu di samping untuk navigasi ke fitur utama.</li>
                        <li>Dashboard ini menampilkan pengumuman dan ringkasan aktivitas penting.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
