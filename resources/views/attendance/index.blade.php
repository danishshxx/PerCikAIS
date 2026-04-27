<x-layouts.app-percikais>
    <x-slot name="title">Jadwal & Presensi - PerCikAIS</x-slot>

    @push('styles')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <style>
        .fc { font-family: inherit; }
        .fc-theme-standard td, .fc-theme-standard th, .fc-theme-standard .fc-scrollgrid { border-color: #e5e7eb; }
        .dark .fc-theme-standard td, .dark .fc-theme-standard th, .dark .fc-theme-standard .fc-scrollgrid { border-color: #1f2937; }
        .dark .fc-col-header-cell-cushion, .dark .fc-daygrid-day-number { color: #9ca3af; text-decoration: none; }
        .fc-col-header-cell-cushion, .fc-daygrid-day-number { color: #4b5563; text-decoration: none; font-weight: 600; }
        .fc .fc-button-primary { background-color: #2563eb; border-color: #2563eb; text-transform: capitalize; border-radius: 0.5rem; }
        .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1d4ed8; border-color: #1d4ed8; }
        .fc-h-event { border: none; padding: 2px 4px; border-radius: 4px; cursor: pointer; }
    </style>
    @endpush

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Jadwal & Presensi Mandiri</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Silakan lakukan absensi atau ajukan izin belajar.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20 rounded-xl border border-green-200 font-medium text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error_pay') || $hasUnpaid)
        <div class="mb-8 p-6 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-900/30 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6 transition-all animate-pulse">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-800 dark:text-red-400">Selesaikan Pembayaran SPP!</h3>
                    <p class="text-xs text-red-700 dark:text-red-500/80">Fitur presensi mandiri & pengajuan izin dikunci sementara hingga tagihan dilunasi.</p>
                </div>
            </div>
            <a href="{{ route('finance.index') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-900/20 transition-all whitespace-nowrap">
                Bayar Sekarang
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
        <div class="xl:col-span-2 space-y-8">
            <!-- Form Absen -->
            <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm relative overflow-hidden transition-colors">
                @if($hasUnpaid)
                    <div class="absolute inset-0 bg-white/60 dark:bg-[#0A0F1C]/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                        <span class="bg-gray-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-xl">Terkunci</span>
                    </div>
                @endif
                <h2 class="font-bold text-lg mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.826z"></path></svg>
                    Kirim Kehadiran / Izin
                </h2>
                <form action="{{ route('attendance.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-[2]">
                            <select name="subject_name" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                <option value="Teknologi Informasi & Komunikasi">Teknologi Informasi & Komunikasi</option>
                                <option value="Matematika Terapan">Matematika Terapan</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Fisika Modern">Fisika Modern</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="status" required class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-[#050B14] dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="Hadir">Hadir (Masuk)</option>
                                <option value="Izin">Izin (Sakit/Keperluan)</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" @if($hasUnpaid) disabled @endif class="w-full py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-900/20">
                        Kirim Presensi
                    </button>
                </form>
                <p class="mt-4 text-[10px] text-gray-500 dark:text-gray-400 italic">* Khusus status "Izin" memerlukan verifikasi manual dari Guru pengampu.</p>
            </div>

            <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm transition-colors">
                <h2 class="font-bold text-lg mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Kalender Akademik
                </h2>
                <div id="calendar" class="min-h-[500px]"></div>
            </div>
        </div>

        <div class="xl:col-span-1 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-5 rounded-2xl border border-blue-100 dark:border-blue-800/50">
                    <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold mb-1 uppercase">Sesi Sah</p>
                    <h3 class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $totalPertemuan }}</h3>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 p-5 rounded-2xl border border-green-100 dark:border-green-800/50">
                    <p class="text-xs text-green-600 dark:text-green-400 font-semibold mb-1 uppercase">Presentase</p>
                    <h3 class="text-3xl font-bold text-green-700 dark:text-blue-300">{{ $persentase }}%</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm transition-colors">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Riwayat Terakhir</h2>
                <div class="space-y-3">
                    @forelse($history->take(10) as $log)
                    <div class="p-3 bg-gray-50 dark:bg-[#121A2F] rounded-xl border border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-xs text-gray-900 dark:text-white truncate pr-2">{{ $log->subject_name }}</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[10px] font-bold px-2 py-1 {{ strtolower($log->status) == 'hadir' ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400' : 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400' }} rounded-md uppercase">
                                {{ $log->status }}
                            </span>
                            @if(!$log->is_verified)
                                <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">Menunggu ACC</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 text-center py-4">Belum ada catatan presensi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @if(!isset($restricted) || !$restricted)
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var today = new Date();
            var y = today.getFullYear();
            var m = String(today.getMonth() + 1).padStart(2, '0');
            var d = String(today.getDate()).padStart(2, '0');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                locale: 'id',
                buttonText: { today: 'Hari Ini', month: 'Bulan', week: 'Minggu', list: 'Agenda' },
                height: 'auto',
                events: [
                    {
                        title: 'Tatap Muka Rutin',
                        start: y + '-' + m + '-' + d + 'T08:00:00',
                        end: y + '-' + m + '-' + d + 'T10:30:00',
                        color: '#2563eb'
                    }
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); 
                    Swal.fire({
                        title: info.event.title,
                        text: "Informasi jadwal akademik harian.",
                        icon: 'info',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#2563eb',
                        customClass: { popup: 'dark:bg-[#0A0F1C] dark:text-white', title: 'dark:text-white' }
                    });
                }
            });
            calendar.render();
        });
    </script>
    @endif
    @endpush
</x-layouts.app-percikais>
