<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasilpemeriksaan extends Model
{
    protected 
        $fillable = [
        'pasien_id',
        'diagnosa',
        'harga_pemeriksaan',
        'dokter_id',
    ];

    public function pasien()
{
    return $this->belongsTo(Pasien::class);
}

public function dokter()
{
    return $this->belongsTo(Dokter::class);
}

public function jadwaldokter()
{
    return $this->hasMany(JadwalDokter::class);
}

public function transaksi()
{
    return $this->hasMany(Transaksi::class);
}

}
