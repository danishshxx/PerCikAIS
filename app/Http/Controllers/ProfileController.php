<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('student.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'nis' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'max:30'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $validated['profile_photo_path'] = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        unset($validated['profile_photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        auth()->logout();

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function mobileQrPayload(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $secret = config('services.rust_backend.jwt_secret', 'percik-super-secret-jwt-key-2026-change-in-production');

        // Generate token payload matching backend structure
        $tokenPayload = [
            'sub' => $user->email,
            'user_id' => $user->id,
            'role' => strtoupper($user->role),
            'iat' => time(),
            'exp' => time() + (30 * 24 * 60 * 60) // 30 days
        ];

        $token = $this->signJwt($tokenPayload, $secret);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => strtoupper($user->role),
            'nim' => $user->nim ?? null,
            'nisn' => $user->nis ?? null,
            'kelas' => $user->kelas ?? null
        ];

        $qrPayload = json_encode([
            'type' => 'login',
            'token' => $token,
            'user' => $userData
        ]);

        return response()->json([
            'success' => true,
            'payload' => $qrPayload
        ]);
    }

    private function signJwt(array $payload, string $secret): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        
        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
        
        $stringToSign = "$base64UrlHeader.$base64UrlPayload";
        $signature = hash_hmac('sha256', $stringToSign, $secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        
        return "$stringToSign.$base64UrlSignature";
    }

    private function base64UrlEncode(string $input): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($input));
    }
}