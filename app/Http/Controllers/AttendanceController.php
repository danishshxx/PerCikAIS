<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LmsCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $history = Attendance::where('user_id', $user->id)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $verifiedHistory = $history->where('is_verified', true);

        $totalPertemuan = $verifiedHistory->count();

        $totalHadir = $verifiedHistory
            ->filter(fn ($attendance) => strtolower($attendance->status) === 'hadir')
            ->count();

        $totalSakitIzin = $verifiedHistory
            ->filter(fn ($attendance) => in_array(strtolower($attendance->status), ['sakit', 'izin']))
            ->count();

        $totalAlpa = $verifiedHistory
            ->filter(fn ($attendance) => strtolower($attendance->status) === 'alpa')
            ->count();

        $persentase = $totalPertemuan > 0
            ? round(($totalHadir / $totalPertemuan) * 100)
            : 0;

        $pendingRequests = $history
            ->where('is_verified', false)
            ->whereIn('status', ['Sakit', 'Izin'])
            ->count();

        $hasUnpaid = method_exists($user, 'hasUnpaidInvoices')
            ? $user->hasUnpaidInvoices()
            : false;

        $lmsCourses = $this->getLmsCourses();

        return view('student.attendance.index', compact(
            'history',
            'totalPertemuan',
            'totalHadir',
            'totalSakitIzin',
            'totalAlpa',
            'persentase',
            'pendingRequests',
            'hasUnpaid',
            'lmsCourses'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'course_id' => ['nullable', 'string', 'max:255'],
            'subject_name' => ['required_without:course_id', 'nullable', 'string', 'max:255'],
            'attendance_date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'in:Sakit,Izin'],
            'absence_reason' => ['nullable', 'string', 'max:1000'],
            'absence_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'subject_name.required_without' => 'Mata pelajaran wajib diisi.',
            'attendance_date.required' => 'Tanggal berhalangan wajib diisi.',
            'attendance_date.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'status.required' => 'Jenis berhalangan wajib dipilih.',
            'status.in' => 'Siswa hanya bisa mengajukan Sakit atau Izin.',
            'absence_letter.required' => 'Surat atau bukti berhalangan wajib diupload.',
            'absence_letter.mimes' => 'Format surat harus PDF, JPG, JPEG, PNG, atau WEBP.',
            'absence_letter.max' => 'Ukuran surat maksimal 2MB.',
        ]);

        $courseId = $validated['course_id'] ?? null;
        $subjectName = $this->resolveSubjectName($courseId, $validated['subject_name'] ?? null);

        $duplicateQuery = Attendance::where('user_id', $user->id)
            ->whereDate('attendance_date', $validated['attendance_date'])
            ->where('subject_name', $subjectName);

        if (Schema::hasColumn('attendances', 'course_id') && $courseId) {
            $duplicateQuery->where('course_id', $courseId);
        }

        if ($duplicateQuery->exists()) {
            return redirect()
                ->route('attendance.index')
                ->with('error', 'Pengajuan untuk mata pelajaran dan tanggal tersebut sudah pernah dibuat.');
        }

        $letterPath = $request->file('absence_letter')
            ->store('absence-letters', 'public');

        $payload = [
            'user_id' => $user->id,
            'subject_name' => $subjectName,
            'attendance_date' => $validated['attendance_date'],
            'status' => $validated['status'],
            'is_verified' => false,
        ];

        if (Schema::hasColumn('attendances', 'course_id')) {
            $payload['course_id'] = $courseId;
        }

        if (Schema::hasColumn('attendances', 'absence_letter_path')) {
            $payload['absence_letter_path'] = $letterPath;
        }

        if (Schema::hasColumn('attendances', 'absence_reason')) {
            $payload['absence_reason'] = $validated['absence_reason'] ?? null;
        }

        Attendance::create($payload);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Pengajuan berhalangan berhasil dikirim. Menunggu verifikasi guru.');
    }

    private function resolveSubjectName(?string $courseId, ?string $subjectName): string
    {
        if (! $courseId) {
            return $subjectName ?: 'Mata Pelajaran Tidak Diketahui';
        }

        try {
            $course = LmsCourse::find($courseId);

            if ($course) {
                return $course->title
                    ?? $course->name
                    ?? $course->subject_name
                    ?? 'Mata Pelajaran Tidak Diketahui';
            }
        } catch (\Throwable $e) {
            //
        }

        return $subjectName ?: 'Mata Pelajaran Tidak Diketahui';
    }

    private function getLmsCourses(): Collection
    {
        try {
            return LmsCourse::orderBy('createdAt', 'desc')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}