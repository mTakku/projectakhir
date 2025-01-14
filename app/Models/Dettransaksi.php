<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dettransaksi extends Model
{
    protected 
    $fillable = [
    'transaksi_id',
    'obat_id',
    'jumlah',
    'total',

];

public function obat()
{
    return $this->belongsTo(Obat::class, 'obat_id');
}
}
