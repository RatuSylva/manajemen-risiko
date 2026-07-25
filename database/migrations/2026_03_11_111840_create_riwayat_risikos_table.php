<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_risikos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('risiko_id')
                ->nullable()
                ->constrained('risikos')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('role_pengguna')->nullable();

            $table->string('jenis_aktivitas');

            $table->string('status_sebelum')->nullable();

            $table->string('status_sesudah')->nullable();

            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_risikos');
    }
};