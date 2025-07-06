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
$data = $request->only([
  'pegawai_id','potongan_id','gaji_pokok','tunjangan',
  'potongan','bulan','keterangan'
]);
$data['total_gaji'] = $total_gaji;
Gaji::create($data);
