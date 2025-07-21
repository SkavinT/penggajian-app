<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji Pegawai</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .slip-container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 24px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h2 { margin: 0; color: #d9534f; }
        .info { margin-bottom: 16px; }
        .info strong { width: 120px; display: inline-block; }
        .amounts { margin-bottom: 16px; }
        .amounts table { width: 100%; border-collapse: collapse; }
        .amounts th, .amounts td { padding: 6px 8px; }
        .amounts th { background: #f2dede; color: #a94442; }
        .amounts tr:nth-child(even) { background: #f9f9f9; }
        .footer { text-align: right; font-size: 12px; color: #888; }
        .no-print { margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
            .slip-container { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;">
        <button onclick="window.print()" style="padding:8px 20px; background:#d9534f; color:#fff; border:none; border-radius:4px; cursor:pointer;">
            Cetak / Simpan PDF Semua Slip Gaji
        </button>
    </div>
    @foreach($gajis as $gaji)
    <div class="slip-container">
        <div class="header">
            <h2>Slip Gaji Pegawai</h2>
            <div>Bulan: <strong>{{ $gaji->bulan }}</strong></div>
        </div>
        <div class="info">
            <div><strong>Nama</strong>: {{ $gaji->pegawai->nama ?? '-' }}</div>
            <div><strong>Jabatan</strong>: {{ $gaji->pegawai->jabatan ?? '-' }}</div>
            <div><strong>Email</strong>: {{ $gaji->pegawai->email ?? '-' }}</div>
        </div>
        <div class="amounts">
            <table>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>Rp {{ number_format($gaji->gaji_pokok,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Tunjangan Transport</th>
                    <td>Rp {{ number_format($gaji->tunjangan_transport ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Tunjangan Makan</th>
                    <td>Rp {{ number_format($gaji->tunjangan_makan ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Tunjangan Lain</th>
                    <td>Rp {{ number_format($gaji->tunjangan ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Potongan Pinjaman</th>
                    <td>Rp {{ number_format($gaji->potongan_pinjaman ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Potongan Keterlambatan</th>
                    <td>Rp {{ number_format($gaji->potongan_keterlambatan ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Potongan Lain</th>
                    <td>Rp {{ number_format($gaji->potongan ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Total Gaji</th>
                    <td><strong>Rp {{ number_format($gaji->total_gaji,0,',','.') }}</strong></td>
                </tr>
            </table>
        </div>
        <div><strong>Keterangan</strong>: {{ $gaji->keterangan ?? '-' }}</div>
        <div class="footer">
            Dicetak pada: {{ now()->format('d-m-Y H:i') }}
        </div>
    </div>
    @endforeach
</body>
</html>