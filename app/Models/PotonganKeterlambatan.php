<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotonganKeterlambatan extends Model
{
    protected $table = 'potongans'; // Nama tabel di database

    protected $fillable = [
        'pegawai_id',       // Relasi ke tabel pegawai
        'jumlah',           // Jumlah potongan
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
