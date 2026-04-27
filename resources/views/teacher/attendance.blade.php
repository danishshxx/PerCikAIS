<x-layouts.teacher-percikais>
    <x-slot name="title">Input Presensi Masal - PerCikAIS</x-slot>

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Presensi Mata Pelajaran</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola kehadiran murid dan verifikasi permohonan izin.</p>
        </div>
        <div class="bg-blue-50 dark:bg-blue-500/10 px-4 py-2 rounded-xl border border-blue-100 dark:border-blue-500/20">
            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ now()->format('l, d M Y') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 rounded-xl border border-green-200 font-medium text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- BAGIAN VERIFIKASI IZIN -->
    @if($pendingAttendances->count() > 0)
    <div class="mb-10">
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-orange-600 dark:text-orange-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Menunggu Verifikasi Izin ({{ $pendingAttendances->count() }})
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($pendingAttendances as $pending)
            <div class="bg-white dark:bg-[#0A0F1C] border border-orange-200 dark:border-orange-900/30 rounded-2xl p-4 shadow-sm flex flex-col justify-between transition-colors">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pending->user->name) }}&background=fed7aa&color=9a3412&rounded=true" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-bold text-sm text-gray-900 dark:text-white">{{ $pending->user->name }}</p>
                        <p class="text-[10px] text-gray-500 uppercase">{{ $pending->subject_name }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4 border-t dark:border-gray-800">
                    <span class="text-[10px] font-bold text-orange-600 uppercase">Izin Pending</span>
                    <form action="{{ route('teacher.attendance.verify', $pending->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold rounded-lg transition-colors">
                            Setujui Izin
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <form action="{{ route('teacher.attendance.store') }}" method="POST">
        @csrf
        <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl overflow-hidden shadow-sm transition-colors">
            
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-[#121A2F]/50 flex flex-col md:flex-row items-center gap-4">
                <label class="font-bold text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Pelajaran :</label>
                <select name="subject_name" required class="flex-1 max-w-md rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    <option value="Teknologi Informasi & Komunikasi">Teknologi Informasi & Komunikasi</option>
                    <option value="Matematika Terapan">Matematika Terapan</option>
                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                    <option value="Fisika Modern">Fisika Modern</option>
                </select>
                <div class="md:ml-auto">
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-900/20 transition-all text-sm">
                        Simpan Semua
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800 tracking-widest font-bold">
                            <th class="p-6">Nama Murid</th>
                            <th class="p-6 text-center">Administrasi</th>
                            <th class="p-6 text-right">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($students as $student)
                        @php $isBlocked = $student->hasUnpaidInvoices(); @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/30 transition-colors {{ $isBlocked ? 'opacity-70 grayscale-[0.5]' : '' }}">
                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=E0E7FF&color=4338CA&rounded=true" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $student->name }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                @if($isBlocked)
                                    <span class="px-3 py-1 rounded-full bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 text-[10px] font-bold uppercase tracking-tight">Belum Lunas</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-green-100 dark:bg-green-500/10 text-green-700 dark:text-green-400 text-[10px] font-bold uppercase tracking-tight">Lunas</span>
                                @endif
                            </td>
                            <td class="p-6">
                                @if($isBlocked)
                                    <p class="text-right text-[10px] text-red-500 font-bold italic">Terkunci</p>
                                @else
                                    <div class="flex items-center justify-end gap-3 md:gap-6">
                                        <label class="flex flex-col items-center gap-1 group cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Hadir" required class="w-4 h-4 text-blue-600">
                                            <span class="text-[10px] font-bold text-gray-400 group-hover:text-blue-500 transition-colors uppercase">H</span>
                                        </label>
                                        <label class="flex flex-col items-center gap-1 group cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Izin" class="w-4 h-4 text-yellow-500">
                                            <span class="text-[10px] font-bold text-gray-400 group-hover:text-yellow-500 transition-colors uppercase">I</span>
                                        </label>
                                        <label class="flex flex-col items-center gap-1 group cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Sakit" class="w-4 h-4 text-orange-500">
                                            <span class="text-[10px] font-bold text-gray-400 group-hover:text-orange-500 transition-colors uppercase">S</span>
                                        </label>
                                        <label class="flex flex-col items-center gap-1 group cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Alpa" class="w-4 h-4 text-red-600">
                                            <span class="text-[10px] font-bold text-gray-400 group-hover:text-red-600 transition-colors uppercase">A</span>
                                        </label>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</x-layouts.teacher-percikais>
