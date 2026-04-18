<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Dummy Siswa',
            'email' => 'murid@sekolah.com', // Ini yang lu masukin di Identifier nanti
            'password' => Hash::make('password123'), // Passwordnya ini
        ]);
    }
}
