<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            /*
             * Identifikasi risiko
             */
            $table->text('penyebab_risiko')
                ->nullable();

            $table->text('dampak_risiko')
                ->nullable();

            /*
             * Analisis risiko saat ini
             */
            $table->text('kontrol_eksisting')
                ->nullable();

            $table->string('efektivitas_kontrol')
                ->nullable();

            $table->decimal(
                'kuantifikasi',
                15,
                2
            )->nullable();

            /*
             * Analisis risiko residual
             */
            $table->unsignedTinyInteger(
                'target_kemungkinan'
            )->nullable();

            $table->unsignedTinyInteger(
                'target_dampak'
            )->nullable();

            $table->unsignedTinyInteger(
                'besaran_risiko_residual'
            )->nullable();

            $table->string(
                'level_risiko_residual'
            )->nullable();

            $table->decimal(
                'kuantifikasi_residual',
                15,
                2
            )->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->dropColumn([
                'penyebab_risiko',
                'dampak_risiko',
                'kontrol_eksisting',
                'efektivitas_kontrol',
                'kuantifikasi',
                'target_kemungkinan',
                'target_dampak',
                'besaran_risiko_residual',
                'level_risiko_residual',
                'kuantifikasi_residual',
            ]);
        });
    }
};