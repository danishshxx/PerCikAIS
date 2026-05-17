<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin akun utama lu (Paksa jadi Admin)
        $user = new User();
        $user->name = 'Muhammad Danish'; 
        $user->email = 'dnshconquer@gmail.com'; // Pastiin ini email Google lu yg dipake login!
        $user->password = Hash::make('password123');
        $user->role = 'admin'; // Wajib diisi biar bisa masuk rute admin.dashboard
        $user->timestamps = false; // Matikan paksa timestamp
        $user->save();

        // Bikin akun dummy siswa
        $student = new User();
        $student->name = 'Dummy Siswa';
        $student->email = 'murid@sekolah.com'; 
        $student->password = Hash::make('password123');
        $student->role = 'student'; 
        $student->timestamps = false; // Matikan paksa timestamp
        $student->save();

        // 2. Bikin tagihan yang belum dibayar (Pending)
        $invoice1 = new Invoice();
        $invoice1->user_id = $user->id;
        $invoice1->order_id = 'INV-' . time() . '-01';
        $invoice1->description = 'SPP Semester Ganjil 2026';
        $invoice1->amount = 4500000;
        $invoice1->status = 'pending';
        $invoice1->timestamps = false; // Matikan paksa timestamp
        $invoice1->save();

        // 3. Bikin riwayat tagihan yang udah lunas (Paid)
        $invoice2 = new Invoice();
        $invoice2->user_id = $user->id;
        $invoice2->order_id = 'INV-' . (time() - 86400) . '-02';
        $invoice2->description = 'Uang Pangkal / Pembangunan';
        $invoice2->amount = 12500000;
        $invoice2->status = 'paid';
        $invoice2->timestamps = false; // Matikan paksa timestamp
        $invoice2->save();
    }
}