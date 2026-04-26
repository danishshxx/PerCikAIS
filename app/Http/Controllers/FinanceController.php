<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice; 
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    public function index()
    {
        // Narik data tagihan murid yang lagi login
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $totalPending = $invoices->where('status', 'pending')->sum('amount');

        return view('finance.index', compact('invoices', 'totalPending'));
    }

    public function getSnapToken($id)
    {
        $invoice = Invoice::findOrFail($id);

        // 👇 TAMBAHIN 2 BARIS INI BANG 👇
        // Kita ganti order_id-nya jadi unik tiap kali tombol diklik (Format: INV-ID-Waktu)
        $invoice->order_id = 'INV-' . $invoice->id . '-' . time();
        $invoice->save();

        // Konfigurasi Midtrans ngambil dari file .env lu
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Data yang dikirim ke Midtrans buat dicatet
        $params = [
            'transaction_details' => [
                'order_id' => $invoice->order_id, // 👈 Otomatis pake ID yang baru diperbarui
                'gross_amount' => $invoice->amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            // MINTA TOKEN ASLI KE MIDTRANS
            $snapToken = Snap::getSnapToken($params);

            // Balikin tokennya ke JavaScript di browser
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receipt($id)
    {
        // Cari data tagihan berdasarkan ID dan pastikan itu milik user yang lagi login
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cegah user iseng buka kuitansi kalau tagihannya belum lunas
        if ($invoice->status !== 'paid') {
            return redirect('/finance')->with('error', 'Kuitansi tidak tersedia. Tagihan ini belum lunas.');
        }

        return view('finance.receipt', compact('invoice'));
    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($invoice->status !== 'paid') {
            abort(403, 'Belum lunas Bang!');
        }

        // Bikin file PDF dari tampilan khusus PDF
        $pdf = Pdf::loadView('finance.receipt_pdf', compact('invoice'));
        
        // Langsung suruh browser download
        return $pdf->download('Kuitansi_SIAKAD_' . $invoice->order_id . '.pdf');
    }
}