<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'gaji_pokok',
        'tunjangan_transport',
        'tunjangan_makan',
        'potongan_pinjaman',
        'potongan_keterlambatan',
        'potongan',
        'tunjangan',
        'bulan',  // tambahkan
        'keterangan',
        'total_gaji',
    ];

    protected $casts = [
        'bulan' => 'date:Y-m', // Ensure the 'bulan' column is cast to the correct format
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function potongan()
    {
        return $this->belongsTo(PotonganKeterlambatan::class, 'potongan_id');
    }
}


