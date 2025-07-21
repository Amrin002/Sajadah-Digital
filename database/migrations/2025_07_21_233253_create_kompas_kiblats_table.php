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
        Schema::create('kompas_kiblats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasis_id')->constrained('lokasis')->onDelete('cascade');
            $table->decimal('arah_kiblat', 5, 2)->comment('dalam derajat');
            $table->decimal('deklinasi_magnetik', 5, 2)->default(0);
            $table->timestamp('terakhir_kalibrasi')->nullable();
            $table->timestamps();

            $table->index('lokasis_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompas_kiblats');
    }
};
