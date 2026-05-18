<?php

namespace App\Console\Commands;

use App\Services\LmsUserSyncService;
use Illuminate\Console\Command;

class SyncUsersToLms extends Command
{
    protected $signature = 'lms:sync-users {--role= : Sync role tertentu saja, contoh: student, teacher, admin}';

    protected $description = 'Sync user Laravel PerCikAIS ke tabel User LMS/Rust/Prisma';

    public function handle(LmsUserSyncService $syncService): int
    {
        $role = $this->option('role');

        $this->info('Mulai sync user ke LMS...');

        $result = $syncService->syncAll($role);

        $this->info('Sync selesai.');
        $this->line('Berhasil: ' . $result['success']);
        $this->line('Gagal: ' . $result['failed']);

        return self::SUCCESS;
    }
}