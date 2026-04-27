<x-layouts.admin-percikais>
    <x-slot name="title">Input Presensi - PerCikAIS</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rekap Absensi Harian</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pilih murid dan catat kehadiran untuk mata pelajaran hari ini.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 rounded-xl border border-green-200 font-medium text-sm transition-colors">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20 rounded-xl border border-red-200 font-medium text-sm transition-colors">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm h-fit transition-colors">
            <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3">Form Input Kehadiran</h2>
            
            <form action="{{ route('admin.attendance.store') }}" method="POST" class="space-y-5 transition-colors">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Murid</label>
                    <select name="user_id" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                        <option value="">-- Pilih Murid --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Pelajaran</label>
                    <input type="text" name="subject_name" required placeholder="Cth: Matematika / Bahasa Inggris" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal KBM</label>
                    <input type="date" name="attendance_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Kehadiran</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 border dark:border-gray-700 dark:bg-[#050B14]/50 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                            <input type="radio" name="status" value="Hadir" required class="text-blue-600 dark:bg-gray-800 focus:ring-blue-500 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Hadir</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border dark:border-gray-700 dark:bg-[#050B14]/50 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                            <input type="radio" name="status" value="Sakit" class="text-yellow-500 dark:bg-gray-800 focus:ring-yellow-500 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sakit</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border dark:border-gray-700 dark:bg-[#050B14]/50 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                            <input type="radio" name="status" value="Izin" class="text-blue-500 dark:bg-gray-800 focus:ring-blue-500 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Izin</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border dark:border-gray-700 dark:bg-[#050B14]/50 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors">
                            <input type="radio" name="status" value="Alpa" class="text-red-600 dark:bg-gray-800 focus:ring-red-500 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Alpa</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all">
                    Simpan Presensi
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-[#0A0F1C] p-6 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm transition-colors">
            <h2 class="font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-800 pb-3">Riwayat Input Hari Ini</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs uppercase text-gray-400 dark:text-gray-500 border-b dark:border-gray-800 tracking-wider">
                            <th class="pb-3 font-semibold">Nama Murid</th>
                            <th class="pb-3 font-semibold hidden sm:table-cell">Mata Pelajaran</th>
                            <th class="pb-3 font-semibold text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 transition-colors overflow-hidden">
                        @forelse($todayAttendances as $absen)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#121A2F]/50 transition-colors rounded-xl overflow-hidden">
                            <td class="py-4 font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($absen->user->name) }}&background=bfdbfe&color=1e3a8a&rounded=true" alt="Avatar" class="w-8 h-8 rounded-full shadow-inner">
                                <div class="flex flex-col">
                                    <span>{{ $absen->user->name }}</span>
                                    <span class="text-[10px] text-gray-500 sm:hidden">{{ $absen->subject_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-gray-500 dark:text-gray-400 hidden sm:table-cell">{{ $absen->subject_name }}</td>
                            <td class="py-4 text-center">
                                @if($absen->status == 'Hadir')
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-2.5 sm:py-1.5 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 rounded-md uppercase tracking-wide transition-colors">Hadir</span>
                                @elseif($absen->status == 'Sakit')
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-2.5 sm:py-1.5 bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400 rounded-md uppercase tracking-wide transition-colors">Sakit</span>
                                @elseif($absen->status == 'Izin')
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-2.5 sm:py-1.5 bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 rounded-md uppercase tracking-wide transition-colors">Izin</span>
                                @else
                                    <span class="text-[10px] sm:text-xs font-bold px-2 py-1 sm:px-2.5 sm:py-1.5 bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 rounded-md uppercase tracking-wide transition-colors">Alpa</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-gray-500 dark:text-gray-400">Belum ada presensi yang diinput hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin-percikais>
