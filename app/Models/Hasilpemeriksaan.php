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

}
