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
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $totalPending = $invoices->where('status', 'pending')->sum('amount');

        return view('finance.index', compact('invoices', 'totalPending'));
    }

    public function getSnapToken($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');

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
            // Nanti kalau key sudah ada, baris ini yang akan bekerja
            // $snapToken = Snap::getSnapToken($params);
            
            // SIMULASI: Karena key belum ada, kita kasih token asal dulu buat ngetes UI
            $snapToken = 'simulated-token-' . time();

            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}