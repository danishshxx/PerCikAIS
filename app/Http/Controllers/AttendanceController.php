<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hasUnpaid = $user->hasUnpaidInvoices();

        // Ambil semua riwayat absensi dari database
        $history = Attendance::where('user_id', $user->id)
                    ->orderBy('attendance_date', 'desc')
                    ->get();

        // Hitung statistik (Hanya yang sudah diverifikasi guru yang dihitung sah)
        $totalPertemuan = $history->where('is_verified', true)->count();
        $totalHadir = $history->where('is_verified', true)->filter(fn($a) => strtolower($a->status) === 'hadir')->count();
        $totalSakitIzin = $history->where('is_verified', true)->filter(fn($a) => in_array(strtolower($a->status), ['sakit', 'izin']))->count();
        $totalAlpa = $history->where('is_verified', true)->filter(fn($a) => strtolower($a->status) === 'alpa')->count();

        // Hitung persentase
        $persentase = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100) : 0;
        
        return view('attendance.index', compact(
            'history', 'totalPertemuan', 'totalHadir', 'totalSakitIzin', 'totalAlpa', 'persentase', 'hasUnpaid'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasUnpaidInvoices()) {
            return redirect()->back()->with('error_pay', 'Kamu tidak bisa melakukan presensi. Harap lunas SPP/Tagihan terlebih dahulu!');
        }

        $request->validate([
            'subject_name' => 'required|string|max:255',
            'status' => 'required|in:Hadir,Izin',
        ]);

        // Kalau absen hadir langsung verified (asumsi kejujuran/geofencing etc bisa dikembangin)
        // Kalau izin harus false biar di-acc guru
        $isVerified = ($request->status === 'Hadir');

        Attendance::create([
            'user_id' => $user->id,
            'subject_name' => $request->subject_name,
            'attendance_date' => date('Y-m-d'),
            'status' => $request->status,
            'is_verified' => $isVerified
        ]);

        $msg = $isVerified ? 'Presensi berhasil dicatat!' : 'Permohonan izin berhasil dikirim! Menunggu verifikasi Guru.';

        return redirect()->route('attendance.index')->with('success', $msg);
    }
}
