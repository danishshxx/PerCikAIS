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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_id')->unique(); // Buat ID unik Midtrans/Xendit
            $table->string('description'); // Misal: "Tagihan SPP Semester Ganjil"
            $table->integer('amount');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('snap_token')->nullable(); // Kalau pakai Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
