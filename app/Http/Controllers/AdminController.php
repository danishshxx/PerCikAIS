<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Attendance;
use App\Models\LmsCourse;
use App\Models\LmsUser;
use Illuminate\Support\Str;
use App\Services\LmsUserSyncService;


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

    public function teachers()
    {
        $teachers = User::where('role', 'teacher')->orderBy('created_at', 'desc')->get();
        return view('admin.teachers', compact('teachers'));
    }

    public function storeTeacher(Request $request)
    {
        $teacher = User::create([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'password' => bcrypt('gurupercik123'),
            'role' => 'teacher',
        ]);

        app(LmsUserSyncService::class)->sync($teacher);

        return redirect()->route('admin.teachers')->with('success', 'Akun guru berhasil didaftarkan dan disinkronkan ke LMS.');
    }

    // Fungsi buat Simpan Data Siswa Baru
    public function storeStudent(Request $request)
    {
        $student = User::create([
                'name' => $request->name,
                'email' => strtolower(trim($request->email)),
                'password' => bcrypt('percik123'),
                'role' => 'student',
            ]);

            app(LmsUserSyncService::class)->sync($student);

        return redirect()->route('admin.students')->with('success', 'Data siswa berhasil didaftarkan dan disinkronkan ke LMS.');
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
        $student = User::findOrFail($request->user_id);

        // CEK APAKAH MURID PUNYA TUNGGAKAN
        if ($student->hasUnpaidInvoices()) {
            return redirect()->route('admin.attendance')->with('error', 'Gagal! Murid ini (' . $student->name . ') masih memiliki tunggakan administrasi yang belum lunas.');
        }

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

    public function subjects()
    {
        try {
            $courses = \App\Models\LmsCourse::with('teacher')
                ->orderBy('createdAt', 'desc')
                ->get();

            $teachers = User::whereRaw('LOWER(role) = ?', ['teacher'])
                ->whereNotNull('rust_user_id')
                ->orderBy('name')
                ->get();

            $unsyncedTeachers = User::whereRaw('LOWER(role) = ?', ['teacher'])
                ->whereNull('rust_user_id')
                ->count();

            $lmsConnected = true;
            $lmsError = null;
        } catch (\Throwable $e) {
            $courses = collect();
            $teachers = collect();
            $unsyncedTeachers = 0;
            $lmsConnected = false;
            $lmsError = $e->getMessage();
        }

        return view('admin.subjects', compact(
            'courses',
            'teachers',
            'unsyncedTeachers',
            'lmsConnected',
            'lmsError'
        ));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'thumbnail_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'teacherId' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Nama mata pelajaran wajib diisi.',
            'teacherId.required' => 'Guru pengampu wajib dipilih.',
        ]);

        try {
            LmsCourse::create([
                'id' => 'c' . substr(str_replace('-', '', Str::uuid()->toString()), 0, 24),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'thumbnail' => $validated['thumbnail'] ?? null,
                'teacherId' => $validated['teacherId'],
                'createdAt' => now(),
            ]);

            return redirect()
                ->route('admin.subjects')
                ->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.subjects')
                ->with('error', 'Gagal menambahkan mata pelajaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateSubject(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'thumbnail_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_thumbnail' => ['nullable', 'boolean'],
            'teacherId' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Nama mata pelajaran wajib diisi.',
            'teacherId.required' => 'Guru pengampu wajib dipilih.',
            'thumbnail_file.mimes' => 'Thumbnail harus berupa JPG, JPEG, PNG, atau WEBP.',
            'thumbnail_file.max' => 'Ukuran thumbnail maksimal 5MB.',
        ]);

        try {
            $course = LmsCourse::findOrFail($id);

            $thumbnailUrl = $course->thumbnail;

            if ($request->boolean('remove_thumbnail')) {
                $this->deleteLocalCourseThumbnail($course->thumbnail);
                $thumbnailUrl = null;
            }

            if ($request->hasFile('thumbnail_file')) {
                $this->deleteLocalCourseThumbnail($course->thumbnail);

                $path = $request->file('thumbnail_file')->store('course-thumbnails', 'public');
                $thumbnailUrl = asset('storage/' . $path);
            }

            $course->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'thumbnail' => $thumbnailUrl,
                'teacherId' => $validated['teacherId'],
            ]);

            return redirect()
                ->route('admin.subjects')
                ->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.subjects')
                ->with('error', 'Gagal memperbarui mata pelajaran: ' . $e->getMessage());
        }
    }

    public function deleteSubject(string $id)
    {
        try {
            $course = LmsCourse::findOrFail($id);
            $course->delete();

            return redirect()
                ->route('admin.subjects')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.subjects')
                ->with('error', 'Gagal menghapus mata pelajaran. Kemungkinan masih dipakai di enrollment, jadwal, quiz, assignment, atau data LMS lain.');
        }
    }

    private function deleteLocalCourseThumbnail(?string $thumbnailUrl): void
    {
        if (! $thumbnailUrl) {
            return;
        }

        $storageMarker = '/storage/';

        if (! str_contains($thumbnailUrl, $storageMarker)) {
            return;
        }

        $relativePath = Str::after($thumbnailUrl, $storageMarker);

        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}