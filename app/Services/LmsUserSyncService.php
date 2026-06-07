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
        return $user->id;
    }

    public function syncAll(?string $role = null): array
    {
        return [
            'success' => 0,
            'failed' => 0,
        ];
    }
}