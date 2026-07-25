<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->dropColumn('efektivitas_kontrol');
        });
    }

    public function down(): void
    {
        Schema::table('risikos', function (Blueprint $table) {
            $table->string('efektivitas_kontrol')
                ->nullable();
        });
    }
};