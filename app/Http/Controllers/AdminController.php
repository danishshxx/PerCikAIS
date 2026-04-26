<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Attendance;


class AdminController extends Controller
{
    public function index()
    {
        // Hitung total buat ditampilin di atas layar Admin
        $totalSiswa = User::where('role', 'student')->count();
        $totalPendapatan = Invoice::where('status', 'paid')->sum('amount');
        $totalTunggakan = Invoice::where('status', 'pending')->sum('amount');

        return view('admin.dashboard', compact('totalSiswa', 'totalPendapatan', 'totalTunggakan'));
    }

    public function students()
    {
        $students = User::where('role', 'student')->orderBy('created_at', 'desc')->get();
        return view('admin.students', compact('students'));
    }

    // 👇 TAMBAHIN FUNGSI INI BANG 👇
    // Fungsi buat Simpan Data Siswa Baru
    public function storeStudent(Request $request)
    {
        // Validasi biar email ga boleh kembar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('percik123'), // Password dummy aja karena nanti login via Google
            'role' => 'student',
        ]);

        return redirect()->route('admin.students')->with('success', 'Data siswa berhasil didaftarkan!');
    }

    public function attendance()
    {
        $students = User::where('role', 'student')->orderBy('name', 'asc')->get();
        // Tarik data absen khusus hari ini
        $todayAttendances = Attendance::with('user')->whereDate('attendance_date', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        
        return view('admin.attendance', compact('students', 'todayAttendances'));
    }

    // TAMBAHIN FUNGSI INI: Buat nyimpen data pas tombol ditekan
    public function storeAttendance(Request $request)
    {
        Attendance::create([
            'user_id' => $request->user_id,
            'subject_name' => $request->subject_name,
            'attendance_date' => $request->attendance_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.attendance')->with('success', 'Absensi berhasil disimpan!');
    }

    public function finance()
    {
        $students = User::where('role', 'student')->orderBy('name', 'asc')->get();
        // Tarik semua tagihan yang ada, urutin dari yang paling baru
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        
        return view('admin.finance', compact('students', 'invoices'));
    }

    // Fungsi buat Bikin Tagihan Baru ke Database
    public function storeInvoice(Request $request)
    {
        // Bikin order_id acak nan unik
        $orderId = 'INV-' . time() . '-' . rand(100, 999);

        Invoice::create([
            'user_id' => $request->user_id,
            'order_id' => $orderId,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => 'pending', // Otomatis pending pas baru dibikin
        ]);

        return redirect()->route('admin.finance')->with('success', 'Tagihan berhasil dikirim ke siswa!');
    }
}