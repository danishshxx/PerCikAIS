<x-layouts.app-percikais>
    <x-slot name="title">Administrasi SPP - PerCikAIS</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Informasi Tagihan & SPP</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pantau dan selesaikan administrasi sekolahmu dengan mudah.</p>
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
                <p class="text-sm text-blue-200 font-semibold mb-1 uppercase tracking-wider">Total Belum Terbayar</p>
                <h3 class="text-3xl font-bold mb-6">Rp {{ number_format($totalPending, 0, ',', '.') }}</h3>
                <p class="text-xs text-blue-200">Pastikan melunasi tagihan tepat waktu untuk kelancaran administrasi ujian.</p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Daftar Tagihan Sekolah</h2>
            
            @forelse($invoices as $invoice)
                <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row justify-between md:items-center gap-4 transition-colors">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $invoice->description }}</p>
                            @if($invoice->status == 'paid')
                                <span class="text-[10px] font-bold px-2 py-1 bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400 rounded-md uppercase">Lunas</span>
                            @else
                                <span class="text-[10px] font-bold px-2 py-1 bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-500 rounded-md uppercase">Menunggu</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 font-mono">No. Invoice: {{ $invoice->order_id }}</p>
                    </div>
                    
                    <div class="flex items-center gap-6 justify-between md:justify-end">
                        <p class="font-bold text-lg text-gray-900 dark:text-white">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                        
                        @if($invoice->status == 'pending')
                            <button type="button" onclick="payNow({{ $invoice->id }})" class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-blue-900/20 whitespace-nowrap">
                                Bayar Sekarang
                            </button>
                        @else
                            <a href="{{ route('finance.receipt', $invoice->id) }}" target="_blank" class="text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Bukti Bayar
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-[#0A0F1C] border border-gray-200 dark:border-gray-800 rounded-3xl p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada catatan tagihan untuk akun ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        function payNow(invoiceId) {
            const loader = document.getElementById('custom-loader');
            loader.classList.remove('hidden');
            loader.classList.add('flex');

            fetch(`/finance/get-token/${invoiceId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.token) {
                        loader.classList.remove('flex');
                        loader.classList.add('hidden');
                        
                        window.snap.pay(data.token, {
                            onSuccess: function(result) {
                                Swal.fire({ icon: 'success', title: 'Pembayaran Berhasil!', text: 'Terima kasih, tagihan sudah lunas terverifikasi.', confirmButtonColor: '#2563EB' }).then(() => { location.reload(); });
                            },
                            onPending: function(result) {
                                Swal.fire({ icon: 'info', title: 'Menunggu Transaksi', text: 'Selesaikan pembayaranmu sesuai petunjuk yang diberikan.', confirmButtonColor: '#2563EB' }).then(() => { location.reload(); });
                            },
                            onError: function(result) {
                                Swal.fire({ icon: 'error', title: 'Gagal Memproses', text: 'Terjadi gangguan saat memproses pembayaran, coba beberapa saat lagi.', confirmButtonColor: '#2563EB' }).then(() => { location.reload(); });
                            },
                            onClose: function() {
                                const cancelledLoader = document.getElementById('cancelled-loader');
                                cancelledLoader.classList.remove('hidden');
                                cancelledLoader.classList.add('flex');
                                setTimeout(function() {
                                    cancelledLoader.classList.remove('flex');
                                    cancelledLoader.classList.add('hidden');
                                }, 800); 
                            }
                        });
                    } else {
                        loader.classList.remove('flex');
                        loader.classList.add('hidden');
                        Swal.fire({ icon: 'error', title: 'Gagal Sistem', text: 'Server tidak dapat merespon permintaan tiket pembayaran.', confirmButtonColor: '#2563EB' });
                    }
                })
                .catch(error => {
                    loader.classList.remove('flex');
                    loader.classList.add('hidden');
                    Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Pastikan perangkatmu terhubung ke internet dengan stabil.', confirmButtonColor: '#2563EB' });
                });
        }
    </script>
    @endpush

    <div id="custom-loader" class="fixed inset-0 z-[9999] bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center transition-all duration-300">
        <div class="bg-white dark:bg-[#0A0F1C] p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm w-full mx-4 border border-gray-200 dark:border-gray-800 transform transition-all">
            <div class="relative w-24 h-24 mb-6 flex items-center justify-center">
                <img src="https://ui-avatars.com/api/?name=S&background=2563EB&color=fff&rounded=true&size=128" alt="Sekolah" class="w-16 h-16 object-contain animate-pulse relative z-10 rounded-full shadow-md">
                <div class="absolute inset-0 border-4 border-blue-100 dark:border-blue-900/50 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 text-center tracking-wide">Menghubungkan...</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center animate-pulse">Membuka gerbang pembayaran sekolah yang aman.</p>
        </div>
    </div>

    <div id="cancelled-loader" class="fixed inset-0 z-[9999] bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center transition-all duration-300">
        <div class="bg-white dark:bg-[#0A0F1C] p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm w-full mx-4 border border-gray-200 dark:border-gray-800 transform transition-all">
            <div class="w-20 h-20 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 text-center tracking-wide">Dibatalkan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Proses pembayaran telah dihentikan oleh pengguna.</p>
        </div>
    </div>
</x-layouts.app-percikais>
