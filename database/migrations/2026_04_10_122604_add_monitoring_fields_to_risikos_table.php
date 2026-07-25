<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->text('sasaran')
                ->nullable();

            $table->string('proyeksi_risiko')
                ->nullable();

            $table->string('tren_risiko')
                ->nullable();

            $table->text('mitigasi_terlaksana')
                ->nullable();

            $table->string('penanggung_jawab')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->dropColumn([
                'sasaran',
                'proyeksi_risiko',
                'tren_risiko',
                'mitigasi_terlaksana',
                'penanggung_jawab',
            ]);
        });
    }
};
