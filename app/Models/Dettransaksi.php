<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dettransaksi extends Model
{
    protected 
    $fillable = [
    'transaksi_id',
    'harga_satuan',
    'obat_id',
    'jumlah',
    'total',

];

public function obat()
{
    return $this->belongsTo(Obat::class, 'obat_id');
}

public function transaksi()
{
    return $this->belongsTo(Transaksi::class, 'transaksi_id');
}

protected static function booted()
{
    static::creating(function ($dettransaksi) {
        $obat = $dettransaksi->obat;
    
        if ($obat->stok < $dettransaksi->jumlah) {
            throw new \Exception('Stok obat tidak mencukupi.');
        }
    
        $obat->decrement('stok', $dettransaksi->jumlah);
    });
    
    static::deleting(function ($dettransaksi) {
        $obat = $dettransaksi->obat;
        $obat->increment('stok', $dettransaksi->jumlah);
    });
}
}
