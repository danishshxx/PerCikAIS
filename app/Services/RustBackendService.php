<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RustBackendService
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.rust_backend.url'), '/');
        $this->timeout = (int) config('services.rust_backend.timeout', 5);
    }

    private function client(): PendingRequest
    {
        $client = Http::timeout($this->timeout)
            ->acceptJson()
            ->asJson();

        $token = session('rust_token');

        if ($token) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    public function health(): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->acceptJson()
                ->get($this->baseUrl . '/health');

            if (! $response->successful()) {
                return [
                    'ok' => false,
                    'message' => 'Rust backend tidak merespons dengan status sukses.',
                    'status' => $response->status(),
                ];
            }

            return [
                'ok' => true,
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::warning('Rust backend health check failed', [
                'message' => $e->getMessage(),
            ]);

            return [
                'ok' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function googleLogin(string $idToken): ?string
    {
        try {
            $response = Http::timeout($this->timeout)
                ->acceptJson()
                ->asJson()
                ->post($this->baseUrl . '/api/auth/google-login', [
                    'id_token' => $idToken,
                ]);

            if (! $response->successful()) {
                Log::warning('Rust google-login failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            return data_get($response->json(), 'token');
        } catch (\Throwable $e) {
            Log::warning('Rust google-login exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function courses(): Collection
    {
        try {
            $response = $this->client()
                ->get($this->baseUrl . '/api/courses');

            if (! $response->successful()) {
                return collect();
            }

            return collect($response->json());
        } catch (\Throwable $e) {
            Log::warning('Rust courses fetch failed', [
                'message' => $e->getMessage(),
            ]);

            return collect();
        }
    }

    public function dashboard(): array
    {
        try {
            $response = $this->client()
                ->get($this->baseUrl . '/api/dashboard');

            if (! $response->successful()) {
                return [];
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::warning('Rust dashboard fetch failed', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }
}