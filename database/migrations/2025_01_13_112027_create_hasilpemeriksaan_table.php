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
        Schema::create('hasilpemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id');
            $table->string('diagnosa');
            $table->string('harga_pemeriksaan');
            $table->foreignId('dokter_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilpemeriksaan');
    }
};
