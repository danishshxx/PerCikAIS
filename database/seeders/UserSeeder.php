<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Bikin 1 akun siswa buat testing
        User::create([
            'name' => 'Dummy Siswa',
            'email' => 'murid@sekolah.com', // Ini yang lu masukin di Identifier nanti
            'password' => Hash::make('password123'), // Passwordnya ini
        ]);
    }
} 