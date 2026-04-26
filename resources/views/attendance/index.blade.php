<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal & Absensi - PerCikAIS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        /* CSS Dikit biar Kalendernya nyatu sama Tailwind & Dark Mode */
        .fc { font-family: inherit; }
        .fc-theme-standard td, .fc-theme-standard th, .fc-theme-standard .fc-scrollgrid { border-color: #e5e7eb; }
        .dark .fc-theme-standard td, .dark .fc-theme-standard th, .dark .fc-theme-standard .fc-scrollgrid { border-color: #1f2937; }
        .dark .fc-col-header-cell-cushion, .dark .fc-daygrid-day-number { color: #9ca3af; text-decoration: none; }
        .fc-col-header-cell-cushion, .fc-daygrid-day-number { color: #4b5563; text-decoration: none; font-weight: 600; }
        .fc .fc-button-primary { background-color: #2563eb; border-color: #2563eb; text-transform: capitalize; border-radius: 0.5rem; }
        .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1d4ed8; border-color: #1d4ed8; }
        .fc-h-event { border: none; padding: 2px 4px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] text-gray-900 dark:text-white flex h-screen overflow-hidden transition-colors duration-300">

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white">S</div>
                    <span class="text-lg font-bold tracking-wider">PerCikAIS</span>
                </div>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
            </div>
            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dasbor
                </a>
                <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal & Kehadiran
                </a>
                <a href="{{ route('finance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F] relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Keuangan
                    @php
                        $pendingCount = \App\Models\Invoice::where('user_id', Auth::id())->where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="absolute right-4 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $pendingCount }}</span>
                    @endif
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors py-2.5 rounded-lg">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Jadwal & Kehadiran</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau jadwal kelas dan rekapitulasi kehadiranmu semester ini.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            
            <div class="xl:col-span-2 bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
                <h2 class="font-bold text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kalender Akademik
                </h2>
                <div id="calendar" class="min-h-[500px]"></div>
            </div>

            <div class="xl:col-span-1 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-5 rounded-2xl border border-blue-100 dark:border-blue-800/50">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold mb-1 uppercase">Pertemuan</p>
                        <h3 class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $totalPertemuan }}</h3>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 p-5 rounded-2xl border border-green-100 dark:border-green-800/50">
                        <p class="text-xs text-green-600 dark:text-green-400 font-semibold mb-1 uppercase">Hadir</p>
                        <h3 class="text-3xl font-bold text-green-700 dark:text-green-300">{{ $persentase }}%</h3>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-5 rounded-2xl border border-yellow-100 dark:border-yellow-800/50">
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 font-semibold mb-1 uppercase">Sakit/Izin</p>
                        <h3 class="text-3xl font-bold text-yellow-700 dark:text-yellow-300">{{ $totalSakitIzin }}</h3>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 p-5 rounded-2xl border border-red-100 dark:border-red-800/50">
                        <p class="text-xs text-red-600 dark:text-red-400 font-semibold mb-1 uppercase">Alpa</p>
                        <h3 class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $totalAlpa }}</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
                    <h2 class="font-bold mb-4">Riwayat Terakhir</h2>
                    <div class="space-y-3">
                        @forelse($history->take(4) as $log)
                        <div class="p-3 bg-gray-50 dark:bg-[#121A2F] rounded-xl border border-gray-100 dark:border-gray-800 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-xs text-gray-900 dark:text-white truncate max-w-[120px]">{{ $log->subject_name }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($log->attendance_date)->format('d M Y') }}</p>
                            </div>
                            @if(strtolower($log->status) == 'hadir')
                                <span class="text-[10px] font-bold px-2 py-1 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 rounded-md uppercase">Hadir</span>
                            @else
                                <span class="text-[10px] font-bold px-2 py-1 bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 rounded-md uppercase">{{ $log->status }}</span>
                            @endif
                        </div>
                        @empty
                        <p class="text-xs text-gray-500 text-center py-4">Belum ada data kehadiran.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Bikin tanggal dinamis biar jadwal dummynya selalu muncul di bulan ini
            var today = new Date();
            var y = today.getFullYear();
            var m = String(today.getMonth() + 1).padStart(2, '0');
            var d = String(today.getDate()).padStart(2, '0');
            
            var tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            var d_tom = String(tomorrow.getDate()).padStart(2, '0');

            // Inisialisasi Kalender
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                locale: 'id', // Bahasa Indonesia
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    list: 'Agenda'
                },
                height: 'auto',
                
                // Data Jadwal Dummy (Nanti lu bisa ganti tarik dari Database)
                events: [
                    {
                        title: 'Integrasi Aplikasi Enterprise',
                        start: y + '-' + m + '-' + d + 'T08:00:00',
                        end: y + '-' + m + '-' + d + 'T10:30:00',
                        color: '#2563eb', // Biru
                        extendedProps: {
                            dosen: 'Pak Budi M.Kom',
                            ruang: 'Lab Komputer B'
                        }
                    },
                    {
                        title: 'Keamanan Sistem Informasi',
                        start: y + '-' + m + '-' + d_tom + 'T13:00:00',
                        color: '#ea580c', // Orange
                        extendedProps: {
                            dosen: 'Bu Siti S.T',
                            ruang: 'Ruang 402'
                        }
                    },
                    {
                        title: 'Batas Akhir Bayar SPP',
                        start: y + '-' + m + '-25',
                        color: '#dc2626', // Merah
                        allDay: true,
                        extendedProps: {
                            dosen: 'Bag. Keuangan',
                            ruang: 'Loket / Online'
                        }
                    }
                ],

                // Aksi Pas Jadwal Diklik -> Munculin SweetAlert
                eventClick: function(info) {
                    // Mencegah error kalau URL kosong
                    info.jsEvent.preventDefault(); 
                    
                    // Ekstrak data dari kalender
                    let namaMatkul = info.event.title;
                    let waktu = info.event.start.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                    let tgl = info.event.start.toLocaleDateString('id-ID', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'});
                    let dosen = info.event.extendedProps.dosen;
                    let ruang = info.event.extendedProps.ruang;

                    // Tembak SweetAlert yang Elegan
                    Swal.fire({
                        title: namaMatkul,
                        html: `
                            <div class="text-left mt-4 space-y-3 bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                <p class="text-sm border-b border-gray-200 dark:border-gray-700 pb-2"><strong class="text-gray-900 dark:text-white inline-block w-20">Tanggal</strong> <span class="text-gray-600 dark:text-gray-400">: ${tgl}</span></p>
                                <p class="text-sm border-b border-gray-200 dark:border-gray-700 pb-2"><strong class="text-gray-900 dark:text-white inline-block w-20">Jam</strong> <span class="text-gray-600 dark:text-gray-400">: ${info.event.allDay ? 'Seharian' : waktu + ' WIB'}</span></p>
                                <p class="text-sm border-b border-gray-200 dark:border-gray-700 pb-2"><strong class="text-gray-900 dark:text-white inline-block w-20">Dosen</strong> <span class="text-gray-600 dark:text-gray-400">: ${dosen}</span></p>
                                <p class="text-sm"><strong class="text-gray-900 dark:text-white inline-block w-20">Ruangan</strong> <span class="text-gray-600 dark:text-gray-400">: ${ruang}</span></p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#2563eb',
                        customClass: {
                            popup: 'dark:bg-[#0A0F1C] dark:text-white',
                            title: 'dark:text-white'
                        }
                    });
                }
            });

            // Render/Tampilin Kalendernya
            calendar.render();
        });
    </script>
</body>
</html>