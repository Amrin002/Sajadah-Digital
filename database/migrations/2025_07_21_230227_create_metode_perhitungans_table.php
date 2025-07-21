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
        Schema::create('metode_perhitungans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->decimal('sudut_subuh', 5, 2);
            $table->decimal('sudut_isya', 5, 2);
            $table->integer('menit_maghrib')->default(0);
            $table->integer('menit_isya')->default(0);
            $table->string('metode_tengah_malam')->default('Standard');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_perhitungans');
    }
};
