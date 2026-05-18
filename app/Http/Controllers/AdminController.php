<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Attendance;
use App\Models\LmsCourse;
use App\Models\LmsUser;
use Illuminate\Support\Str;


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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('gurupercik123'),
            'role' => 'teacher',
        ]);

        return redirect()->route('admin.teachers')->with('success', 'Akun Guru berhasil didaftarkan!');
    }

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
            $courses = LmsCourse::with('teacher')
                ->orderBy('createdAt', 'desc')
                ->get();

            $teachers = LmsUser::query()
                ->whereRaw('UPPER(role) = ?', ['TEACHER'])
                ->orderBy('name')
                ->get();

            $lmsConnected = true;
            $lmsError = null;
        } catch (\Throwable $e) {
            $courses = collect();
            $teachers = collect();
            $lmsConnected = false;
            $lmsError = $e->getMessage();
        }

        return view('admin.subjects', compact(
            'courses',
            'teachers',
            'lmsConnected',
            'lmsError'
        ));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'thumbnail' => ['nullable', 'string', 'max:1000'],
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
            'thumbnail' => ['nullable', 'string', 'max:1000'],
            'teacherId' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Nama mata pelajaran wajib diisi.',
            'teacherId.required' => 'Guru pengampu wajib dipilih.',
        ]);

        try {
            $course = LmsCourse::findOrFail($id);

            $course->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'thumbnail' => $validated['thumbnail'] ?? null,
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
}