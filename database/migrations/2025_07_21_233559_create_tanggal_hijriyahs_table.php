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
        Schema::create('tanggal_hijriyahs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_masehi')->unique();
            $table->integer('hari_hijriyah');
            $table->integer('bulan_hijriyah');
            $table->integer('tahun_hijriyah');
            $table->string('nama_bulan_hijriyah');
            $table->boolean('hari_libur')->default(false);
            $table->string('nama_hari_libur')->nullable();
            $table->timestamps();

            $table->index('tanggal_masehi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggal_hijriyahs');
    }
};
