<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_risikos', function (Blueprint $table) {
            $table->json('data_sebelum')
                ->nullable()
                ->after('status_sesudah');

            $table->json('data_sesudah')
                ->nullable()
                ->after('data_sebelum');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_risikos', function (Blueprint $table) {
            $table->dropColumn([
                'data_sebelum',
                'data_sesudah',
            ]);
        });
    }
};