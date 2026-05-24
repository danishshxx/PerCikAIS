<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LmsCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $courses = $this->teacherCourses();
        $enrollments = $this->teacherEnrollmentRows();
        $pendingRequests = $this->pendingAbsenceRequests()->limit(5)->get();
        $todayAttendances = $this->todayAttendances()->limit(8)->get();

        return view('teacher.dashboard', [
            'courses' => $courses,
            'enrollments' => $enrollments,
            'pendingRequests' => $pendingRequests,
            'todayAttendances' => $todayAttendances,
            'totalCourses' => $courses->count(),
            'totalEnrolledStudents' => $enrollments->pluck('userId')->unique()->count(),
            'totalPendingRequests' => $this->pendingAbsenceRequests()->count(),
            'totalTodayAttendances' => $this->todayAttendances()->count(),
        ]);
    }

    public function attendance()
    {
        $courses = $this->teacherCourses();

        $studentSearch = trim((string) request('student_q'));

        $students = $this->teacherStudents($studentSearch);

        $pendingRequests = $this->pendingAbsenceRequests()
            ->orderBy('created_at', 'desc')
            ->get();

        $todayAttendances = $this->todayAttendances()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.attendance', compact(
            'courses',
            'students',
            'studentSearch',
            'pendingRequests',
            'todayAttendances'
        ));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['nullable', 'string', 'max:255'],
            'subject_name' => ['required_without:course_id', 'nullable', 'string', 'max:255'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Sakit,Izin,Alpa'],
        ]);

        $courseId = $validated['course_id'] ?? null;

        if ($courseId && ! $this->teacherOwnsCourse($courseId)) {
            abort(403);
        }

        $subjectName = $this->resolveSubjectName($courseId, $validated['subject_name'] ?? null);

        $duplicateQuery = Attendance::where('user_id', $validated['user_id'])
            ->whereDate('attendance_date', $validated['attendance_date'])
            ->where('subject_name', $subjectName);

        if (Schema::hasColumn('attendances', 'course_id') && $courseId) {
            $duplicateQuery->where('course_id', $courseId);
        }

        if ($duplicateQuery->exists()) {
            return redirect()
                ->route('teacher.attendance')
                ->with('error', 'Absensi untuk murid, mapel, dan tanggal tersebut sudah ada.');
        }

        $payload = [
            'user_id' => $validated['user_id'],
            'subject_name' => $subjectName,
            'attendance_date' => $validated['attendance_date'],
            'status' => $validated['status'],
            'is_verified' => true,
        ];

        if (Schema::hasColumn('attendances', 'course_id')) {
            $payload['course_id'] = $courseId;
        }

        Attendance::create($payload);

        return redirect()
            ->route('teacher.attendance')
            ->with('success', 'Absensi siswa berhasil dicatat.');
    }

    public function verifyAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);

        if (
            Schema::hasColumn('attendances', 'course_id')
            && $attendance->course_id
            && ! $this->teacherOwnsCourse($attendance->course_id)
        ) {
            abort(403);
        }

        $attendance->update([
            'is_verified' => true,
        ]);

        return redirect()
            ->route('teacher.attendance')
            ->with('success', 'Pengajuan berhalangan berhasil diverifikasi.');
    }

    public function enrollments()
    {
        $courses = $this->teacherCourses();

        $students = User::whereRaw('LOWER(role) = ?', ['student'])
            ->orderBy('name')
            ->get();

        $unsyncedStudents = User::whereRaw('LOWER(role) = ?', ['student'])
            ->whereNull('rust_user_id')
            ->count();

        $enrollments = $this->teacherEnrollmentRows();

        return view('teacher.enrollments', compact(
            'courses',
            'students',
            'unsyncedStudents',
            'enrollments'
        ));
    }

    public function storeEnrollment(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'exists:users,id'],
        ]);

        if (! $this->lmsEnrollmentReady()) {
            return redirect()
                ->route('teacher.enrollments')
                ->with('error', 'Tabel Enrollment/Course/User LMS belum siap.');
        }

        if (! $this->teacherOwnsCourse($validated['course_id'])) {
            abort(403);
        }

        $student = User::findOrFail($validated['student_id']);

        if (! $student->rust_user_id) {
            return redirect()
                ->route('teacher.enrollments')
                ->with('error', 'Murid belum tersinkron ke LMS. Jalankan php artisan lms:sync-users --role=student.');
        }

        $exists = DB::connection('mysql_lms')
            ->table('Enrollment')
            ->where('courseId', $validated['course_id'])
            ->where('userId', $student->rust_user_id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('teacher.enrollments')
                ->with('error', 'Murid sudah terdaftar di mata pelajaran tersebut.');
        }

        $payload = [
            'courseId' => $validated['course_id'],
            'userId' => $student->rust_user_id,
        ];

        if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'id')) {
            $payload['id'] = $this->makeCuid();
        }

        if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'progress')) {
            $payload['progress'] = 0;
        }

        if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'createdAt')) {
            $payload['createdAt'] = now();
        }

        if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'updatedAt')) {
            $payload['updatedAt'] = now();
        }

        if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'enrolledAt')) {
            $payload['enrolledAt'] = now();
        }

        DB::connection('mysql_lms')
            ->table('Enrollment')
            ->insert($payload);

        return redirect()
            ->route('teacher.enrollments')
            ->with('success', 'Murid berhasil dienroll ke mata pelajaran.');
    }

    public function deleteEnrollment(string $courseId, string $studentRustId)
    {
        if (! $this->teacherOwnsCourse($courseId)) {
            abort(403);
        }

        DB::connection('mysql_lms')
            ->table('Enrollment')
            ->where('courseId', $courseId)
            ->where('userId', $studentRustId)
            ->delete();

        return redirect()
            ->route('teacher.enrollments')
            ->with('success', 'Enrollment murid berhasil dihapus.');
    }

    private function teacherCourses()
    {
        try {
            $teacherRustId = Auth::user()->rust_user_id;

            if (! $teacherRustId || ! Schema::connection('mysql_lms')->hasTable('Course')) {
                return collect();
            }

            return LmsCourse::where('teacherId', $teacherRustId)
                ->orderBy('createdAt', 'desc')
                ->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function teacherCourseIds()
    {
        return $this->teacherCourses()
            ->pluck('id')
            ->filter()
            ->values();
    }

    private function teacherOwnsCourse(string $courseId): bool
    {
        return $this->teacherCourseIds()->contains($courseId);
    }

    private function teacherEnrollmentRows()
    {
        try {
            if (! $this->lmsEnrollmentReady()) {
                return collect();
            }

            $courseIds = $this->teacherCourseIds();

            if ($courseIds->isEmpty()) {
                return collect();
            }

            $select = [
                'e.courseId',
                'e.userId',
                'c.title as course_title',
                'u.name as student_name',
                'u.email as student_email',
            ];

            if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'progress')) {
                $select[] = 'e.progress';
            }

            if (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'createdAt')) {
                $select[] = 'e.createdAt as enrolled_at';
            } elseif (Schema::connection('mysql_lms')->hasColumn('Enrollment', 'enrolledAt')) {
                $select[] = 'e.enrolledAt as enrolled_at';
            }

            return DB::connection('mysql_lms')
                ->table('Enrollment as e')
                ->join('Course as c', 'c.id', '=', 'e.courseId')
                ->join('User as u', 'u.id', '=', 'e.userId')
                ->whereIn('e.courseId', $courseIds)
                ->select($select)
                ->orderBy('c.title')
                ->orderBy('u.name')
                ->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function pendingAbsenceRequests()
    {
        $query = Attendance::with('user')
            ->where('is_verified', false)
            ->whereIn('status', ['Sakit', 'Izin']);

        $courseIds = $this->teacherCourseIds();

        if (Schema::hasColumn('attendances', 'course_id')) {
            if ($courseIds->isEmpty()) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('course_id', $courseIds);
            }
        }

        return $query;
    }

    private function todayAttendances()
    {
        $query = Attendance::with('user')
            ->whereDate('attendance_date', today());

        $courseIds = $this->teacherCourseIds();

        if (Schema::hasColumn('attendances', 'course_id')) {
            if ($courseIds->isEmpty()) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('course_id', $courseIds);
            }
        }

        return $query;
    }

    private function resolveSubjectName(?string $courseId, ?string $fallback): string
    {
        if (! $courseId) {
            return $fallback ?: 'Mata Pelajaran Tidak Diketahui';
        }

        try {
            $course = LmsCourse::find($courseId);

            if ($course) {
                return $course->title ?? $fallback ?? 'Mata Pelajaran Tidak Diketahui';
            }
        } catch (\Throwable $e) {
            //
        }

        return $fallback ?: 'Mata Pelajaran Tidak Diketahui';
    }

    private function lmsEnrollmentReady(): bool
    {
        return Schema::connection('mysql_lms')->hasTable('Enrollment')
            && Schema::connection('mysql_lms')->hasTable('Course')
            && Schema::connection('mysql_lms')->hasTable('User');
    }

    private function teacherStudents(?string $search = null)
    {
        try {
            if (! $this->lmsEnrollmentReady()) {
                return collect();
            }

            $courseIds = $this->teacherCourseIds();

            if ($courseIds->isEmpty()) {
                return collect();
            }

            $studentRustIds = DB::connection('mysql_lms')
                ->table('Enrollment')
                ->whereIn('courseId', $courseIds)
                ->pluck('userId')
                ->filter()
                ->unique()
                ->values();

            if ($studentRustIds->isEmpty()) {
                return collect();
            }

            return User::whereRaw('LOWER(role) = ?', ['student'])
                ->whereIn('rust_user_id', $studentRustIds)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                    });
                })
                ->orderBy('name')
                ->limit(50)
                ->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function makeCuid(): string
    {
        return 'c' . substr(str_replace('-', '', Str::uuid()->toString()), 0, 24);
    }
}