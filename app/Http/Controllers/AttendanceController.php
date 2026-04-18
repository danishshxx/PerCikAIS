<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // CUMA ADA FUNGSI INDEX (READ-ONLY)
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua riwayat absensi dari database
        $history = Attendance::where('user_id', $userId)
                    ->orderBy('attendance_date', 'desc')
                    ->get();

        // Hitung statistik buat ditampilin di atas layar
        $totalPertemuan = $history->count();
        $totalHadir = $history->where('status', 'hadir')->count();
        $totalSakitIzin = $history->whereIn('status', ['sakit', 'izin'])->count();
        $totalAlpa = $history->where('status', 'alpa')->count();

        // Hitung persentase (cegah error dibagi nol)
        $persentase = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100) : 0;

        return view('attendance.index', compact(
            'history', 'totalPertemuan', 'totalHadir', 'totalSakitIzin', 'totalAlpa', 'persentase'
        ));
    }
}