<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/finance/notification',
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\DetectMobile::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'teacher' => \App\Http\Middleware\IsTeacher::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            $maxPostSize = ini_get('post_max_size') ?: 'ukuran yang diizinkan server';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'File yang diupload terlalu besar.',
                    'detail' => 'Maksimal ukuran request server saat ini adalah ' . $maxPostSize . '.',
                ], 413);
            }

            return redirect()
                ->back()
                ->with('error', 'File yang diupload terlalu besar. Maksimal ukuran request server saat ini adalah ' . $maxPostSize . '. Silakan pilih gambar yang lebih kecil atau kompres gambar terlebih dahulu.');
        });
    })->create();
