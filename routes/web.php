<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Ubah route '/' biar otomatis nge-redirect ke halaman login
Route::redirect('/', '/login');

// 2. Route dashboard (Bawaan Breeze, udah aman diproteksi sesi 'auth')
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- SISA KODE BAWAAN BREEZE DI BAWAH SINI BIARIN AJA ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';