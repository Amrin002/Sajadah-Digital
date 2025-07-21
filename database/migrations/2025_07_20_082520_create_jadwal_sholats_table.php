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
        Schema::create('jadwal_sholats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('nama_sholat', ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);
            $table->boolean('sudah_sholat')->default(false);
            $table->time('waktu_sholat')->nullable();
            $table->enum('status_sholat', ['tepat_waktu', 'terlambat', 'qadha', 'terlewat'])
                ->default('tepat_waktu');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['users_id', 'tanggal', 'nama_sholat']);
            $table->index(['users_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sholats');
    }
};
