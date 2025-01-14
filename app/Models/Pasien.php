<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pasien extends Model
{
    use HasFactory;

    protected 
        $fillable = [
        'no_antrian',
        'nama_pasien',
        'jk',
        'alamat',
        'umur',
        'keluhan',
    ];

    public function transaksi()
{
    return $this->hasMany(Transaksi::class);
}

public function hasilPemeriksaan()
{
    return $this->hasMany(Hasilpemeriksaan::class, 'pasien_id');
}

public function pasien()
{
    return $this->belongsTo(Pasien::class);
}
}
