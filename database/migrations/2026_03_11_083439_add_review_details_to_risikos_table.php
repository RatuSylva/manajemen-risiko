<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->string('status_reviu')
                ->default('Belum Direviu');

            $table->foreignId('pereviu_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('tanggal_reviu')
                ->nullable();

            $table->text('catatan_perbaikan')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pereviu_id');

            $table->dropColumn([
                'status_reviu',
                'tanggal_reviu',
                'catatan_perbaikan',
            ]);
        });
    }
};
