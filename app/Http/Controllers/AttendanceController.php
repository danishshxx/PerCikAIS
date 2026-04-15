<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Menampilkan Halaman Jadwal & Riwayat Absensi
    public function index()
    {
        $history = Attendance::where('user_id', Auth::id())
                    ->orderBy('attendance_date', 'desc')
                    ->get();

        return view('attendance.index', compact('history'));
    }

    // Menangani Klik Tombol Absensi
    public function store(Request $request)
    {
        $today = now()->format('Y-m-d');
        $subject = 'Integrasi Aplikasi Enterprise';

        // Cek apakah sudah absen hari ini
        $alreadyAttended = Attendance::where('user_id', Auth::id())
            ->where('subject_name', $subject)
            ->where('attendance_date', $today)
            ->exists();

        if ($alreadyAttended) {
            return back()->with('error', 'Kamu sudah mengisi kehadiran hari ini.');
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'subject_name' => $subject,
            'attendance_date' => $today,
            'status' => 'hadir'
        ]);

        return back()->with('success', 'Berhasil mengisi kehadiran!');
    }
}