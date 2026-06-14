<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::post('/auth/qr-login', [GoogleAuthController::class, 'qrLoginCallback']);

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
| Route webhook tidak boleh masuk middleware auth.
*/

Route::post('/finance/notification', [FinanceController::class, 'handleNotification'])
    ->name('finance.notification');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
| Satu pintu setelah login. Sistem akan arahkan berdasarkan role.
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('student.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
| Route student tetap pakai nama lama agar layout dan controller student
| yang sudah dibuat tidak rusak.
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/student/dashboard', 'student.dashboard')
        ->name('student.dashboard');

    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendance/store', [AttendanceController::class, 'store'])
        ->name('attendance.store');

    Route::get('/finance', [FinanceController::class, 'index'])
        ->name('finance.index');

    Route::get('/finance/get-token/{id}', [FinanceController::class, 'getSnapToken'])
        ->name('finance.token');

    Route::get('/finance/receipt/{id}', [FinanceController::class, 'receipt'])
        ->name('finance.receipt');

    Route::get('/finance/receipt/{id}/download', [FinanceController::class, 'downloadPDF'])
        ->name('finance.receipt.download');

    Route::view('/settings', 'student.settings.index')
        ->name('settings.index');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/profile/mobile-qr-payload', [ProfileController::class, 'mobileQrPayload'])
        ->name('profile.mobile-qr-payload');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');

        Route::view('/settings', 'teacher.settings.index')->name('settings');

        Route::get('/attendance', [TeacherController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/store', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
        Route::post('/attendance/verify/{id}', [TeacherController::class, 'verifyAttendance'])->name('attendance.verify');

        Route::get('/enrollments', [TeacherController::class, 'enrollments'])->name('enrollments');
        Route::post('/enrollments', [TeacherController::class, 'storeEnrollment'])->name('enrollments.store');
        Route::delete('/enrollments/{courseId}/{studentRustId}', [TeacherController::class, 'deleteEnrollment'])->name('enrollments.delete');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Semua admin punya akses yang sama. Tidak ada super admin.
*/

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::view('/settings', 'admin.settings.index')
            ->name('settings');

        Route::get('/students', [AdminController::class, 'students'])
            ->name('students');

        Route::post('/students/store', [AdminController::class, 'storeStudent'])
            ->name('students.store');

        Route::patch('/students/{user}', [AdminController::class, 'updateStudent'])
            ->name('students.update');

        Route::delete('/students/{user}', [AdminController::class, 'deleteStudent'])
            ->name('students.delete');

        Route::get('/teachers', [AdminController::class, 'teachers'])
            ->name('teachers');

        Route::post('/teachers/store', [AdminController::class, 'storeTeacher'])
            ->name('teachers.store');

        Route::patch('/teachers/{user}', [AdminController::class, 'updateTeacher'])
            ->name('teachers.update');

        Route::delete('/teachers/{user}', [AdminController::class, 'deleteTeacher'])
            ->name('teachers.delete');

        Route::get('/subjects', [AdminController::class, 'subjects'])
            ->name('subjects');

        Route::post('/subjects/store', [AdminController::class, 'storeSubject'])
            ->name('subjects.store');

        Route::patch('/subjects/{id}', [AdminController::class, 'updateSubject'])
            ->name('subjects.update');

        Route::delete('/subjects/{id}', [AdminController::class, 'deleteSubject'])
            ->name('subjects.delete');

        Route::get('/attendance', [AdminController::class, 'attendance'])
            ->name('attendance');

        Route::post('/attendance/store', [AdminController::class, 'storeAttendance'])
            ->name('attendance.store');

        Route::patch('/attendance/{attendance}', [AdminController::class, 'updateAttendance'])
            ->name('attendance.update');

        Route::delete('/attendance/{attendance}', [AdminController::class, 'deleteAttendance'])
            ->name('attendance.delete');

        Route::get('/finance', [AdminController::class, 'finance'])
            ->name('finance');

        Route::post('/finance/store', [AdminController::class, 'storeInvoice'])
            ->name('finance.store');

        Route::patch('/finance/{invoice}', [AdminController::class, 'updateInvoice'])
            ->name('finance.update');

        Route::delete('/finance/{invoice}', [AdminController::class, 'deleteInvoice'])
            ->name('finance.delete');
    });

require __DIR__ . '/auth.php';