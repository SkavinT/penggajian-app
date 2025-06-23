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
        'tunjangan',
        'potongan',
        'total_gaji',
        'bulan', // ubah dari 'tanggal'
        'keterangan',
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
