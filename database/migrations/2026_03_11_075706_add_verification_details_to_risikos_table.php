<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->foreignId('verifikator_id')
                ->nullable()
                ->after('status_verifikasi')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('tanggal_verifikasi')
                ->nullable()
                ->after('verifikator_id');

            $table->text('catatan_verifikasi')
                ->nullable()
                ->after('tanggal_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verifikator_id');

            $table->dropColumn([
                'tanggal_verifikasi',
                'catatan_verifikasi',
            ]);
        });
    }
};