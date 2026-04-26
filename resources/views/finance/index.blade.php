<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keuangan - SIAKAD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#050B14] text-gray-900 dark:text-white flex h-screen overflow-hidden transition-colors duration-300">

    <aside class="w-64 bg-white dark:bg-[#0A0F1C] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl text-white">S</div>
                    <span class="text-lg font-bold tracking-wider">SIAKAD</span>
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
                <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#121A2F]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Jadwal & Absensi
                </a>
                <a href="{{ route('finance.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-500 border border-blue-200 dark:border-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Keuangan
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Siswa Aktif</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-500/10 py-2.5 rounded-lg">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Keuangan & Tagihan</h1>
            <p class="text-sm text-gray-500">Kelola dan selesaikan administrasi akademikmu.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 text-sm text-green-800 rounded-2xl bg-green-50 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/50">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <p class="text-sm text-blue-200 font-semibold mb-1 uppercase tracking-wider">Total Tunggakan</p>
                    <h3 class="text-3xl font-bold mb-6">Rp {{ number_format($totalPending, 0, ',', '.') }}</h3>
                    <p class="text-xs text-blue-200">Pastikan melunasi tagihan sebelum masa KRS dimulai.</p>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-lg font-semibold mb-4">Daftar Tagihan (Invoice)</h2>
                
                @forelse($invoices as $invoice)
                    <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row justify-between md:items-center gap-4 transition-colors">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <p class="font-bold text-gray-900 dark:text-white">{{ $invoice->description }}</p>
                                @if($invoice->status == 'paid')
                                    <span class="text-[10px] font-bold px-2 py-1 bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400 rounded-md uppercase">Lunas</span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-1 bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-500 rounded-md uppercase">Pending</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 font-mono">{{ $invoice->order_id }}</p>
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <p class="font-bold text-lg text-gray-900 dark:text-white">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                            
                            @if($invoice->status == 'pending')
                                <button type="button" onclick="payNow({{ $invoice->id }})" class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-blue-900/20 whitespace-nowrap">
                                    Bayar Sekarang
                                </button>
                            @else
                                <a href="{{ route('finance.receipt', $invoice->id) }}" target="_blank" class="text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Kuitansi
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-8 text-center">
                        <p class="text-gray-500">Tidak ada tagihan saat ini.</p>
                    </div>
                @endforelse
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
        function payNow(invoiceId) {
            // 1. Panggil Layar Loading Logo Sekolah
            const loader = document.getElementById('custom-loader');
            loader.classList.remove('hidden');
            loader.classList.add('flex');

            // 2. Minta Snap Token ke Server
            fetch(`/finance/get-token/${invoiceId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.token) {
                        // 3. Token dapet, tutup layar loading!
                        loader.classList.remove('flex');
                        loader.classList.add('hidden');
                        
                        // 4. Buka Popup Midtrans
                        window.snap.pay(data.token, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Terima kasih, tagihan kamu sudah lunas.',
                                    confirmButtonColor: '#2563EB'
                                }).then(() => { location.reload(); });
                            },
                            onPending: function(result) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Menunggu Pembayaran',
                                    text: 'Silakan selesaikan pembayaran sesuai instruksi.',
                                    confirmButtonColor: '#2563EB'
                                }).then(() => { location.reload(); });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    text: 'Terjadi kesalahan saat memproses pembayaran.',
                                    confirmButtonColor: '#2563EB'
                                }).then(() => { location.reload(); });
                            },
                            
                            onClose: function() {
                                // 👇 UPDATE FUNGSI KETIKA TOMBOL SILANG DIKLIK 👇
                                
                                // 1. Ambil ID Layar Batal
                                const cancelledLoader = document.getElementById('cancelled-loader');
                                
                                // 2. Munculin layarnya (Ganti hidden jadi flex)
                                cancelledLoader.classList.remove('hidden');
                                cancelledLoader.classList.add('flex');
                                
                                // 3. Set timer: Ilang sendiri abis 3 detik (3000 ms)
                                setTimeout(function() {
                                    // Tutup layarnya lagi
                                    cancelledLoader.classList.remove('flex');
                                    cancelledLoader.classList.add('hidden');
                                    
                                    // Opsi: Lu bisa nambahin location.reload() di sini kalau mau halamannya seger lagi, 
                                    // tapi mending diem gini aja biar murid kaga bingung.
                                }, 800); 

                                console.log('User membatalkan transaksi.');
                            }

                        });
                    } else {
                        // Tutup loader kalau error token
                        loader.classList.remove('flex');
                        loader.classList.add('hidden');
                        Swal.fire({ icon: 'error', title: 'Error Server', text: 'Gagal mendapatkan tiket pembayaran dari server.', confirmButtonColor: '#2563EB' });
                    }
                })
                .catch(error => {
                    // Tutup loader kalau error internet/fetch
                    loader.classList.remove('flex');
                    loader.classList.add('hidden');
                    Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Terjadi kesalahan sistem atau jaringan.', confirmButtonColor: '#2563EB' });
                });
        }
    </script>

    <div id="custom-loader" class="fixed inset-0 z-[9999] bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center transition-all duration-300">
        <div class="bg-white dark:bg-[#0A0F1C] p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm w-full mx-4 border border-gray-200 dark:border-gray-800 transform transition-all">
            
            <div class="relative w-24 h-24 mb-6 flex items-center justify-center">
                <img src="https://ui-avatars.com/api/?name=S&background=2563EB&color=fff&rounded=true&size=128" 
                     alt="Logo Sekolah" 
                     class="w-16 h-16 object-contain animate-pulse relative z-10 rounded-full shadow-md">
                
                <div class="absolute inset-0 border-4 border-blue-100 dark:border-blue-900/50 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 text-center tracking-wide">Memproses...</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center animate-pulse">Menyiapkan gerbang pembayaran yang aman.</p>
        </div>
    </div>

    <div id="cancelled-loader" class="fixed inset-0 z-[9999] bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center transition-all duration-300">
        <div class="bg-white dark:bg-[#0A0F1C] p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm w-full mx-4 border border-gray-200 dark:border-gray-800 transform transition-all">
            
            <div class="w-20 h-20 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 text-center tracking-wide">Transaksi Batal</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Kamu menutup gerbang pembayaran. Silakan coba lagi nanti.</p>
        </div>
    </div>
</body>
</html>