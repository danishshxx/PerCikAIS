<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuitansi - {{ $invoice->order_id }}</title>
    @vite(['resources/css/app.css'])
    <style>
        /* CSS khusus biar pas di-print, tombolnya ngilang */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 py-10 flex justify-center min-h-screen items-start">

    <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl border border-gray-200 overflow-hidden relative">
        
        <div class="h-2 w-full bg-blue-600"></div>

        <div class="p-8 md:p-12">
            <div class="flex justify-between items-start mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-xl text-white">S</div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900">SIAKAD</h1>
                    </div>
                    <p class="text-sm text-gray-500">Institut Teknologi & Bisnis Cikini<br>Jl. Pendidikan No. 123, Jakarta Raya</p>
                </div>
                <div class="text-right">
                    <h2 class="text-3xl font-bold text-gray-200 uppercase tracking-widest">Kuitansi</h2>
                    <p class="text-sm font-semibold text-blue-600 mt-2">{{ $invoice->order_id }}</p>
                </div>
            </div>

            <div class="flex justify-between items-end border-b border-gray-200 pb-6 mb-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Diterima Dari:</p>
                    <p class="text-lg font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Tanggal Bayar:</p>
                    <p class="text-sm font-bold text-gray-900">{{ $invoice->updated_at->format('d F Y - H:i') }} WIB</p>
                </div>
            </div>

            <table class="w-full mb-8">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 text-xs text-gray-500 uppercase tracking-wider font-semibold">Deskripsi Pembayaran</th>
                        <th class="text-right py-3 text-xs text-gray-500 uppercase tracking-wider font-semibold">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-4 text-sm font-medium text-gray-900">{{ $invoice->description }}</td>
                        <td class="py-4 text-sm font-bold text-gray-900 text-right">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="py-4 text-sm font-bold text-gray-500 text-right uppercase">Total Dibayar</td>
                        <td class="py-4 text-2xl font-bold text-blue-600 text-right">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="flex justify-between items-center mt-12">
                <div class="text-xs text-gray-400">
                    <p>Kuitansi ini dicetak otomatis oleh sistem.</p>
                    <p>Sah dan diakui tanpa tanda tangan basah.</p>
                </div>
                <div class="border-4 border-green-500 text-green-500 font-bold uppercase tracking-widest py-2 px-6 rounded-lg transform -rotate-12 opacity-80">
                    LUNAS
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 flex justify-end gap-3 no-print">
            <a href="{{ route('finance.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-xl transition-colors">
                Kembali
            </a>
            <button onclick="window.print()" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Kuitansi
            </button>
        </div>
    </div>

</body>
</html>