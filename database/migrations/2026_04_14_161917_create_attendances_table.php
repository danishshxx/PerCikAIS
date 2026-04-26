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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Sambungin ke tabel users (siswa)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subject_name');
            $table->date('attendance_date');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa']);
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
