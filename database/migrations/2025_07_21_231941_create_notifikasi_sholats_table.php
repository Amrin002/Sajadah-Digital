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
        Schema::create('notifikasi_sholats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->enum('nama_sholat', ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);
            $table->boolean('is_active')->default(true);
            $table->integer('menit_sebelum')->default(0);
            $table->enum('jenis_notifikasi', ['adzan', 'getar', 'diam'])->default('adzan');
            $table->string('path_suara_khusus')->nullable();
            $table->timestamps();

            $table->unique(['users_id', 'nama_sholat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_sholats');
    }
};
