<?php

namespace App\Observers;

use App\Models\Dettransaksi;

class DettransaksiObserver
{
    /**
     * Handle the Dettransaksi "created" event.
     */
    public function created(Dettransaksi $dettransaksi): void
    {
        //
    }

    /**
     * Handle the Dettransaksi "updated" event.
     */
    public function updated(Dettransaksi $dettransaksi): void
    {
        //
    }

    /**
     * Handle the Dettransaksi "deleted" event.
     */
    public function deleted(Dettransaksi $dettransaksi): void
    {
        //
    }

    /**
     * Handle the Dettransaksi "restored" event.
     */
    public function restored(Dettransaksi $dettransaksi): void
    {
        //
    }

    /**
     * Handle the Dettransaksi "force deleted" event.
     */
    public function forceDeleted(Dettransaksi $dettransaksi): void
    {
        //
    }

    public function saved(Dettransaksi $dettransaksi)
    {
        // Ambil transaksi terkait
        $transaksi = $dettransaksi->transaksi;

        // Hitung total harga dari semua detail transaksi
        $hargaTotal = $transaksi->details->sum('total');

        // Update harga_total di transaksi
        $transaksi->update(['harga_total' => $hargaTotal]);
    }
}
