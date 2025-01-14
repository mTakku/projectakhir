<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Hasilpemeriksaan;


class Transaksi extends Model
{
    protected 
        $fillable = [
        'pasien_id',
        'hasilpemeriksaan_id',
        'tanggal_transaksi',
        'harga_total',
    ];

    public function hasilpemeriksaan()
{
    return $this->belongsTo(Hasilpemeriksaan::class);
}

public function pasien()
{
    return $this->belongsTo(Pasien::class);
}

public function details()
{
    return $this->hasMany(Dettransaksi::class);
}


}
