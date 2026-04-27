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

// Midtrans Notification (Webhook)
Route::post('/finance/notification', [FinanceController::class, 'handleNotification']);

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Utama (Auto Redirect)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isTeacher()) return redirect()->route('teacher.dashboard');
        return view('dashboard');
    })->name('dashboard');

    // Fitur Absensi & Jadwal
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

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

// Panel Guru
Route::middleware(['auth', 'teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/attendance', [\App\Http\Controllers\TeacherController::class, 'attendance'])->name('teacher.attendance');
    Route::post('/attendance/store', [\App\Http\Controllers\TeacherController::class, 'storeAttendance'])->name('teacher.attendance.store');
    Route::post('/attendance/verify/{id}', [\App\Http\Controllers\TeacherController::class, 'verifyAttendance'])->name('teacher.attendance.verify');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Fitur Absensi & Jadwal Admin
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('admin.attendance');
    Route::post('/attendance/store', [AdminController::class, 'storeAttendance'])->name('admin.attendance.store');
    
    // Kelola Siswa
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::post('/students/store', [AdminController::class, 'storeStudent'])->name('admin.students.store');

    // Kelola Guru
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::post('/teachers/store', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');

    // Fitut kelola keuangan
    Route::get('/finance', [AdminController::class, 'finance'])->name('admin.finance');
    Route::post('/finance/store', [AdminController::class, 'storeInvoice'])->name('admin.finance.store');
});
require __DIR__.'/auth.php';