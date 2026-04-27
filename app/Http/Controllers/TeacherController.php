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
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'attendance' => 'required|array',
        ]);

        $subject = $request->subject_name;
        $date = date('Y-m-d');
        $savedCount = 0;
        $failedCount = 0;

        foreach ($request->attendance as $userId => $status) {
            $student = User::find($userId);
            
            if ($student && $student->hasUnpaidInvoices()) {
                $failedCount++;
                continue; 
            }

            // Input Guru otomatis verified = true
            Attendance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'subject_name' => $subject,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $status,
                    'is_verified' => true
                ]
            );
            $savedCount++;
        }

        $msg = "Berhasil menyimpan $savedCount data presensi.";
        if ($failedCount > 0) {
            $msg .= " ($failedCount murid memiliki tunggakan).";
        }

        return redirect()->route('teacher.attendance')->with('success', $msg);
    }

    public function verifyAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->is_verified = true;
        $attendance->save();

        return redirect()->route('teacher.attendance')->with('success', 'Permohonan izin ' . $attendance->user->name . ' telah disetujui.');
    }
}
