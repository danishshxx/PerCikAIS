<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FinanceController;

Route::redirect('/', '/login');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Fitur Absensi & Jadwal
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Finance
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance/pay/{id}', [FinanceController::class, 'pay'])->name('finance.pay');
});

require __DIR__.'/auth.php';