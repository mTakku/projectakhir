<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dettransaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id');
            $table->foreignId('obat_id');
            $table->string('harga_satuan');
            $table->string('jumlah');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dettransaksis');
    }
};
