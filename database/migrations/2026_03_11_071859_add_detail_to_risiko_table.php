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
    if (!Schema::hasColumn('risikos', 'user_id')) {
        Schema::table('risikos', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    if (!Schema::hasColumn('risikos', 'besaran_risiko')) {
        Schema::table('risikos', function (Blueprint $table) {
            $table->unsignedTinyInteger('besaran_risiko')->nullable();
        });
    }

    if (!Schema::hasColumn('risikos', 'rencana_penanganan')) {
        Schema::table('risikos', function (Blueprint $table) {
            $table->text('rencana_penanganan')->nullable();
        });
    }

    if (!Schema::hasColumn('risikos', 'batas_waktu')) {
        Schema::table('risikos', function (Blueprint $table) {
            $table->date('batas_waktu')->nullable();
        });
    }
}

    public function down(): void
{
    Schema::table('risikos', function (Blueprint $table) {
        $table->dropConstrainedForeignId('user_id');

        $table->dropColumn([
            'besaran_risiko',
            'batas_waktu',
        ]);
    });
}
};
