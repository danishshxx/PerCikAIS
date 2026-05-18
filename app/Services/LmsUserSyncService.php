<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LmsUserSyncService
{
    public function sync(User $user): ?string
    {
        try {
            if (! Schema::connection('mysql_lms')->hasTable('User')) {
                $this->markFailed($user, 'Tabel User LMS tidak ditemukan.');
                return null;
            }

            $email = strtolower(trim($user->email));
            $role = strtoupper((string) $user->role);

            if (! in_array($role, ['ADMIN', 'TEACHER', 'STUDENT'], true)) {
                $role = 'STUDENT';
            }

            $existing = DB::connection('mysql_lms')
                ->table('User')
                ->where('email', $email)
                ->first();

            $lmsUserId = $existing?->id ?: $this->makeCuid();

            $payload = [
                'name' => $user->name,
                'email' => $email,
                'role' => $role,
            ];

            if (Schema::connection('mysql_lms')->hasColumn('User', 'updatedAt')) {
                $payload['updatedAt'] = now();
            }

            if (Schema::connection('mysql_lms')->hasColumn('User', 'nim')) {
                $payload['nim'] = $user->nis ?? null;
            }

            if (Schema::connection('mysql_lms')->hasColumn('User', 'nisn')) {
                $payload['nisn'] = $user->nis ?? null;
            }

            if (Schema::connection('mysql_lms')->hasColumn('User', 'kelas')) {
                $payload['kelas'] = $user->kelas ?? null;
            }

            if ($existing) {
                DB::connection('mysql_lms')
                    ->table('User')
                    ->where('id', $lmsUserId)
                    ->update($payload);
            } else {
                $payload['id'] = $lmsUserId;

                if (Schema::connection('mysql_lms')->hasColumn('User', 'password')) {
                    $payload['password'] = Hash::make(Str::random(40));
                }

                if (Schema::connection('mysql_lms')->hasColumn('User', 'createdAt')) {
                    $payload['createdAt'] = now();
                }

                if (Schema::connection('mysql_lms')->hasColumn('User', 'totpEnabled')) {
                    $payload['totpEnabled'] = false;
                }

                DB::connection('mysql_lms')
                    ->table('User')
                    ->insert($payload);
            }

            $this->markSynced($user, $lmsUserId);

            return $lmsUserId;
        } catch (\Throwable $e) {
            $this->markFailed($user, $e->getMessage());
            return null;
        }
    }

    public function syncAll(?string $role = null): array
    {
        $query = User::query();

        if ($role) {
            $query->whereRaw('LOWER(role) = ?', [strtolower($role)]);
        }

        $success = 0;
        $failed = 0;

        $query->orderBy('id')->chunk(100, function ($users) use (&$success, &$failed) {
            foreach ($users as $user) {
                $result = $this->sync($user);

                if ($result) {
                    $success++;
                } else {
                    $failed++;
                }
            }
        });

        return [
            'success' => $success,
            'failed' => $failed,
        ];
    }

    private function makeCuid(): string
    {
        return 'c' . substr(str_replace('-', '', Str::uuid()->toString()), 0, 24);
    }

    private function markSynced(User $user, string $lmsUserId): void
    {
        $payload = [];

        if (Schema::hasColumn('users', 'rust_user_id')) {
            $payload['rust_user_id'] = $lmsUserId;
        }

        if (Schema::hasColumn('users', 'rust_synced_at')) {
            $payload['rust_synced_at'] = now();
        }

        if (Schema::hasColumn('users', 'rust_sync_status')) {
            $payload['rust_sync_status'] = 'synced';
        }

        if (Schema::hasColumn('users', 'rust_sync_error')) {
            $payload['rust_sync_error'] = null;
        }

        if (! empty($payload)) {
            $user->forceFill($payload)->save();
        }
    }

    private function markFailed(User $user, string $message): void
    {
        $payload = [];

        if (Schema::hasColumn('users', 'rust_sync_status')) {
            $payload['rust_sync_status'] = 'failed';
        }

        if (Schema::hasColumn('users', 'rust_sync_error')) {
            $payload['rust_sync_error'] = mb_substr($message, 0, 1000);
        }

        if (! empty($payload)) {
            $user->forceFill($payload)->save();
        }
    }
}