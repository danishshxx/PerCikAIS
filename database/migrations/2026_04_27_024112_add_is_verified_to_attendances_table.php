<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // is_verified default true biar data lama & input guru angsung lunas/sah
            if (!Schema::hasColumn('attendances', 'is_verified')) {
                $table->boolean('is_verified')->default(true)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
