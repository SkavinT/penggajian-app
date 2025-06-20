<!-- resources/views/gaji/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Data Gaji</h1>

    <!-- Filter Bulan dan Tahun -->
    <form method="GET" action="{{ route('gaji.index') }}" class="row g-3 mb-4">
        <div class="col-auto">
            <select name="bulan" class="form-select">
                <option value="">-- Pilih Bulan --</option>
                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $nama)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="tahun" class="form-select">
                <option value="">-- Pilih Tahun --</option>
                @for($th = date('Y'); $th >= 2020; $th--)
                    <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filter</button>
        </div>
    </form>

    <!-- Tombol Tambah Data Gaji -->
    <div class="mb-3">
        @can('create', App\Models\Gaji::class)
            <a href="{{ route('gaji.create') }}" class="btn btn-primary">Tambah Data Gaji</a>
        @endcan
    </div>

    <!-- Tabel Menampilkan Data Gaji Responsive -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Potongan</th>
                    <th>Total Gaji</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gajis as $index => $gaji)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->pegawai->nama }}</td>
                    <td>{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->tunjangan ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->potongan ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                    <td>{{ $gaji->keterangan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @can('update', $gaji)
                            <a href="{{ route('gaji.edit', $gaji->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $gajis->withQueryString()->links() }}

</div>
@endsection
