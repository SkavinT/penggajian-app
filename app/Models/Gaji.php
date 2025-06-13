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
        'tanggal',
        'bulan',
        'keterangan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function potongan()
    {
        return $this->belongsTo(PotonganKeterlambatan::class, 'potongan_id');
    }
}
