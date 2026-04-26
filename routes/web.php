<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AdminController;

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
    // Halaman Utama Keuangan
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/get-token/{id}', [FinanceController::class, 'getSnapToken'])->name('finance.token');
    Route::get('/finance/receipt/{id}', [FinanceController::class, 'receipt'])->name('finance.receipt');

    //Kuitansi
    Route::get('/finance/receipt/{id}/download', [FinanceController::class, 'downloadPDF'])->name('finance.receipt.download');
});

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Fitur Absensi & Jadwal Admin
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('admin.attendance');
    Route::post('/attendance/store', [AdminController::class, 'storeAttendance'])->name('admin.attendance.store');
    
    // Kelola Siswa
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::post('/students/store', [AdminController::class, 'storeStudent'])->name('admin.students.store');

    // Fitut kelola keuangan
    Route::get('/finance', [AdminController::class, 'finance'])->name('admin.finance');
    Route::post('/finance/store', [AdminController::class, 'storeInvoice'])->name('admin.finance.store');
});
require __DIR__.'/auth.php';