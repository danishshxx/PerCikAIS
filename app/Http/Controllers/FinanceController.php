<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice; 
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

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

        // Konfigurasi Midtrans ngambil dari file .env lu
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Data yang dikirim ke Midtrans buat dicatet
        $params = [
            'transaction_details' => [
                'order_id' => $invoice->order_id,
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
}