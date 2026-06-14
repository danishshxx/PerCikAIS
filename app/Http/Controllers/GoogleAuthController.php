<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RustBackendService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    public function callback(RustBackendService $rustBackend): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $email = strtolower(trim($googleUser->getEmail()));

            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            // Auto-sync dari tabel LMS `user` jika belum ada di tabel Laravel `users`
            if (! $user) {
                $user = $this->syncFromLmsUser($email, $googleUser->getName());
            }

            if (! $user) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Akses ditolak. Email kamu belum terdaftar di sistem sekolah. Silakan hubungi Administrator.');
            }

            Auth::login($user, true);

            $request = request();
            $request->session()->regenerate();

            $this->storeRustTokenIfAvailable($googleUser, $rustBackend);
            $this->recordLoginLog($user, $request);

            return redirect()->intended($this->redirectPathByRole($user));
        } catch (\Throwable $e) {
            Log::error('Google login failed', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Login Google gagal. Silakan coba lagi atau hubungi Administrator.');
        }
    }

    public function qrLoginCallback(Request $request): JsonResponse
    {
        try {
            $qrJwt = $request->input('qrJwt');

            if (! $qrJwt) {
                return response()->json([
                    'success' => false,
                    'error' => 'No QR token provided',
                ], 400);
            }

            // Verify and retrieve user data by calling Rust Backend /api/auth/me
            $backendUrl = rtrim(config('services.rust_backend.url'), '/');
            $response = \Illuminate\Support\Facades\Http::timeout(5)
                ->acceptJson()
                ->withToken($qrJwt)
                ->get("$backendUrl/api/auth/me");

            if (! $response->successful()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid or unverified token payload',
                ], 400);
            }

            $userData = $response->json();
            $email = strtolower(trim($userData['email'] ?? ''));

            if (! $email) {
                return response()->json([
                    'success' => false,
                    'error' => 'Email not found in token',
                ], 400);
            }

            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            // Auto-sync dari tabel LMS `User` jika belum ada di tabel Laravel `users`
            if (! $user) {
                $user = $this->syncFromLmsUser($email, $userData['name'] ?? null);
            }

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not found in database',
                ], 404);
            }

            Auth::login($user, true);

            $request->session()->regenerate();

            session(['rust_token' => $qrJwt]);

            $this->recordLoginLog($user, $request);

            return response()->json([
                'success' => true,
                'redirect' => $this->redirectPathByRole($user),
            ]);
        } catch (\Throwable $e) {
            Log::error('QR login failed', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'QR login gagal.',
            ], 500);
        }
    }

    private function redirectPathByRole(User $user): string
    {
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return route('teacher.dashboard');
        }

        return route('student.dashboard');
    }

    private function storeRustTokenIfAvailable(object $googleUser, RustBackendService $rustBackend): void
    {
        $idToken = $this->extractGoogleIdToken($googleUser);

        if (! $idToken) {
            session()->forget('rust_token');

            Log::info('Google id_token not available, Rust protected API token skipped.');

            return;
        }

        $rustToken = $rustBackend->googleLogin($idToken);

        if ($rustToken) {
            session(['rust_token' => $rustToken]);

            return;
        }

        session()->forget('rust_token');
    }

    private function extractGoogleIdToken(object $googleUser): ?string
    {
        $possibleSources = [
            data_get($googleUser, 'accessTokenResponseBody.id_token'),
            data_get($googleUser, 'user.id_token'),
            data_get($googleUser, 'id_token'),
        ];

        foreach ($possibleSources as $token) {
            if (is_string($token) && trim($token) !== '') {
                return $token;
            }
        }

        return null;
    }


    /**
     * Cek apakah email ada di tabel LMS `User`, lalu auto-create di tabel Laravel `users`.
     */
    private function syncFromLmsUser(string $email, ?string $fallbackName = null): ?User
    {
        try {
            $lmsUser = DB::table('User')
                ->whereRaw('LOWER(email) = ?', [$email])
                ->first();

            if (! $lmsUser) {
                return null;
            }

            $role = strtolower($lmsUser->role ?? 'student');
            $name = $lmsUser->name ?? $fallbackName ?? 'User';

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                'role' => $role,
            ]);

            Log::info('Auto-synced user from LMS table', [
                'email' => $email,
                'lms_user_id' => $lmsUser->id,
                'role' => $role,
            ]);

            return $user;
        } catch (\Throwable $e) {
            Log::warning('Failed to auto-sync from LMS user table', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function recordLoginLog(User $user, Request $request): void
    {
        try {
            if (! Schema::hasTable('login_logs')) {
                return;
            }

            DB::table('login_logs')->insert([
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role ?? 'student',
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
                'login_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Failed to record login log', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}