<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected 
        $fillable = [
        'dokter_id',
        'jadwalhari',
        'start_time',
        'end_time',
        'available',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public static function boot()
{
    parent::boot();

    static::saving(function ($schedule) {
        $startTime = strtotime($schedule->start_time);
        $endTime = strtotime($schedule->end_time);

        if ($startTime >= $endTime) {
            throw new \Exception('Waktu mulai tidak boleh lebih besar atau sama dengan waktu selesai.');
        }
    });
}
}
