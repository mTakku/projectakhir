<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    //

    protected 
    $fillable = [
    'nama_dokter',
    'spesialis',

];

public function jadwaldokter()
{
    return $this->hasMany(JadwalDokter::class);
}
}
