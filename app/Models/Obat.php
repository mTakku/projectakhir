<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    //
    protected 
        $fillable = [
        'nama_obat',
        'jenis_obat',
        'jenis_obat',
        'tanggal_kd',
        'stok',
        'harga',
        'tipe_obat',
        
    ];
}
