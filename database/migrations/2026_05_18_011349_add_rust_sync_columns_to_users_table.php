<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rust_user_id')->nullable()->unique()->after('id');
            $table->timestamp('rust_synced_at')->nullable()->after('rust_user_id');
            $table->string('rust_sync_status')->nullable()->after('rust_synced_at');
            $table->text('rust_sync_error')->nullable()->after('rust_sync_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'rust_user_id',
                'rust_synced_at',
                'rust_sync_status',
                'rust_sync_error',
            ]);
        });
    }
};