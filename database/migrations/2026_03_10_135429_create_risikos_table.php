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
        Schema::create('risikos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_risiko');
            $table->string('nama_risiko');
            $table->string('kategori_risiko');
            $table->text('deskripsi')->nullable();
            $table->integer('kemungkinan');
            $table->integer('dampak');
            $table->string('level_risiko');
            $table->string('warna_level')->nullable();
            $table->text('rencana penanganan')->nullable();
            $table->string('status_penanganan')->default('Belum Ditangani');
            $table->string('status_verifikasi')->default('Belum Diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risikos');
    }
};
