<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $totalMurid = User::where('role', 'student')->count();
        $absensiHariIni = Attendance::whereDate('attendance_date', date('Y-m-d'))->count();
        $pendingIzin = Attendance::where('is_verified', false)->count();
        
        return view('teacher.dashboard', compact('totalMurid', 'absensiHariIni', 'pendingIzin'));
    }

    public function attendance()
    {
        $students = User::where('role', 'student')->orderBy('name', 'asc')->get();
        // Ambil data yang butuh verifikasi (Izin dari siswa)
        $pendingAttendances = Attendance::with('user')
                                ->where('is_verified', false)
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('teacher.attendance', compact('students', 'pendingAttendances'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'subject_name' => ['required', 'string', 'max:255'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Sakit,Izin,Alpa'],
        ]);

        Attendance::create([
            'user_id' => $validated['user_id'],
            'subject_name' => $validated['subject_name'],
            'attendance_date' => $validated['attendance_date'],
            'status' => $validated['status'],
            'is_verified' => true,
        ]);

        return redirect()
            ->route('teacher.attendance')
            ->with('success', 'Absensi siswa berhasil dicatat.');
    }

    public function verifyAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'is_verified' => true,
        ]);

        return redirect()
            ->route('teacher.attendance')
            ->with('success', 'Pengajuan berhalangan berhasil diverifikasi.');
    }
}
