<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'gaji_pokok',
        'alamat',
        'telepon',
    ];

    public function potongans()
    {
        return $this->hasMany(PotonganKeterlambatan::class, 'pegawai_id');
    }

    public function gajis()
    {
        return $this->hasMany(Gaji::class, 'pegawai_id');
    }
    
    public function tunjangans()
    {
        return $this->hasMany(Tunjangan::class, 'pegawai_id');
    }
}
