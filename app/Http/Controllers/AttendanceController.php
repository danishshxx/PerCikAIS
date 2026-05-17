<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\LmsCourse;
use Illuminate\Support\Collection;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hasUnpaid = $user->hasUnpaidInvoices();

        $history = Attendance::where('user_id', $user->id)
            ->orderBy('attendance_date', 'desc')
            ->get();

        $totalPertemuan = $history->where('is_verified', true)->count();

        $totalHadir = $history
            ->where('is_verified', true)
            ->filter(fn ($a) => strtolower($a->status) === 'hadir')
            ->count();

        $totalSakitIzin = $history
            ->where('is_verified', true)
            ->filter(fn ($a) => in_array(strtolower($a->status), ['sakit', 'izin']))
            ->count();

        $totalAlpa = $history
            ->where('is_verified', true)
            ->filter(fn ($a) => strtolower($a->status) === 'alpa')
            ->count();

        $persentase = $totalPertemuan > 0
            ? round(($totalHadir / $totalPertemuan) * 100)
            : 0;

        $lmsCourses = $this->getSafeLmsCourses();

        return view('attendance.index', compact(
            'history',
            'totalPertemuan',
            'totalHadir',
            'totalSakitIzin',
            'totalAlpa',
            'persentase',
            'hasUnpaid',
            'lmsCourses'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasUnpaidInvoices()) {
            return redirect()
                ->back()
                ->with('error_pay', 'Kamu tidak bisa melakukan presensi. Harap lunas SPP/Tagihan terlebih dahulu!');
        }

        $request->validate([
            'course_id' => 'required|string',
            'status' => 'required|in:Hadir,Izin',
        ]);

        $subjectName = $this->getSafeCourseName($request->course_id);

        $isVerified = $request->status === 'Hadir';

        Attendance::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'subject_name' => $subjectName,
            'attendance_date' => date('Y-m-d'),
            'status' => $request->status,
            'is_verified' => $isVerified,
        ]);

        $msg = $isVerified
            ? 'Presensi berhasil dicatat!'
            : 'Permohonan izin berhasil dikirim! Menunggu verifikasi Guru.';

        return redirect()
            ->route('attendance.index')
            ->with('success', $msg);
    }

    private function getSafeLmsCourses(): Collection
    {
        try {
            return LmsCourse::orderBy('createdAt', 'desc')->get();
        } catch (\Throwable $e) {
            return collect([
                (object) [
                    'id' => 'dummy-tik',
                    'title' => 'Teknologi Informasi & Komunikasi',
                    'name' => 'Teknologi Informasi & Komunikasi',
                    'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                    'createdAt' => now(),
                ],
                (object) [
                    'id' => 'dummy-matematika',
                    'title' => 'Matematika',
                    'name' => 'Matematika',
                    'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                    'createdAt' => now()->subDay(),
                ],
                (object) [
                    'id' => 'dummy-bahasa-indonesia',
                    'title' => 'Bahasa Indonesia',
                    'name' => 'Bahasa Indonesia',
                    'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                    'createdAt' => now()->subDays(2),
                ],
            ]);
        }
    }

    private function getSafeCourseName(string $courseId): string
    {
        $dummyCourses = $this->getDummyCourses();

        $dummyCourse = $dummyCourses->firstWhere('id', $courseId);

        if ($dummyCourse) {
            return $dummyCourse->title;
        }

        try {
            $course = LmsCourse::find($courseId);

            return $course?->title
                ?? $course?->name
                ?? 'Mata Pelajaran Tidak Diketahui';
        } catch (\Throwable $e) {
            return 'Mata Pelajaran Sementara';
        }
    }

    private function getDummyCourses(): Collection
    {
        return collect([
            (object) [
                'id' => 'dummy-tik',
                'title' => 'Teknologi Informasi & Komunikasi',
                'name' => 'Teknologi Informasi & Komunikasi',
                'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                'createdAt' => now(),
            ],
            (object) [
                'id' => 'dummy-matematika',
                'title' => 'Matematika',
                'name' => 'Matematika',
                'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                'createdAt' => now()->subDay(),
            ],
            (object) [
                'id' => 'dummy-bahasa-indonesia',
                'title' => 'Bahasa Indonesia',
                'name' => 'Bahasa Indonesia',
                'description' => 'Data sementara untuk kebutuhan perapihan UI.',
                'createdAt' => now()->subDays(2),
            ],
        ]);
    }
}
