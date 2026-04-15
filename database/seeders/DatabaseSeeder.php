<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash; // NAH INI OBATNYA BANG 👇

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin akun dummy
        $user = User::create([
            'name' => 'Dummy Siswa',
            'email' => 'murid@sekolah.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Bikin tagihan yang belum dibayar (Pending)
        Invoice::create([
            'user_id' => $user->id,
            'order_id' => 'INV-' . time() . '-01',
            'description' => 'SPP Semester Ganjil 2026',
            'amount' => 4500000,
            'status' => 'pending',
        ]);

        // 3. Bikin riwayat tagihan yang udah lunas (Paid)
        Invoice::create([
            'user_id' => $user->id,
            'order_id' => 'INV-' . (time() - 86400) . '-02',
            'description' => 'Uang Pangkal / Pembangunan',
            'amount' => 12500000,
            'status' => 'paid',
        ]);
    }
}