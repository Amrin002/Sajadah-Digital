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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('metode_perhitungans_id')->constrained('metode_perhitungans');
            $table->enum('metode_ashar', ['Syafii', 'Hanafi'])->default('Syafii');
            $table->string('aturan_lintang_tinggi')->default('TengahMalam');
            $table->enum('format_waktu', ['12', '24'])->default('24');
            $table->string('suara_notifikasi')->default('default');
            $table->enum('tema', ['terang', 'gelap', 'sistem'])->default('sistem');
            $table->enum('bahasa', ['id', 'en', 'ar'])->default('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
