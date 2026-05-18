<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (! Schema::hasColumn('attendances', 'absence_letter_path')) {
                $table->string('absence_letter_path')->nullable()->after('is_verified');
            }

            if (! Schema::hasColumn('attendances', 'absence_reason')) {
                $table->text('absence_reason')->nullable()->after('absence_letter_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'absence_letter_path')) {
                $table->dropColumn('absence_letter_path');
            }

            if (Schema::hasColumn('attendances', 'absence_reason')) {
                $table->dropColumn('absence_reason');
            }
        });
    }
};