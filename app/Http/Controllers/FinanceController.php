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
        // Konfigurasi Midtrans buat auto-cek status
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        // Narik data tagihan murid yang lagi login
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // CEK STATUS KE MIDTRANS (Jika masih pending & ada order_id)
        foreach ($invoices as $invoice) {
            if ($invoice->status === 'pending' && $invoice->order_id) {
                try {
                    $status = \Midtrans\Transaction::status($invoice->order_id);
                    $this->updateInvoiceStatus($invoice, $status->transaction_status, $status->fraud_status ?? null);
                } catch (\Exception $e) {
                    // Abaikan jika order_id belum terdaftar atau ada error koneksi
                }
            }
        }

        // Ambil data terbaru setelah proses cek status
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $totalPending = $invoices->where('status', 'pending')->sum('amount');

        return view('finance.index', compact('invoices', 'totalPending'));
    }

    private function updateInvoiceStatus($invoice, $transaction, $fraud)
    {
        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $invoice->status = 'pending';
            } else {
                $invoice->status = 'paid';
            }
        } else if ($transaction == 'settlement') {
            $invoice->status = 'paid';
        } else if ($transaction == 'pending') {
            $invoice->status = 'pending';
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $invoice->status = 'failed';
        }
        
        if ($invoice->isDirty('status')) {
            $invoice->save();
        }
    }

    public function getSnapToken($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Update order_id tiap kali minta token baru biar gak bentrok di Midtrans
        $invoice->order_id = 'INV-' . $invoice->id . '-' . time();
        $invoice->save();

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

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
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notification = new \Midtrans\Notification();
            $invoice = Invoice::where('order_id', $notification->order_id)->first();

            if ($invoice) {
                $this->updateInvoiceStatus($invoice, $notification->transaction_status, $notification->fraud_status);
            }

            return response()->json(['message' => 'Notification handled']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receipt($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($invoice->status !== 'paid') {
            return redirect('/finance')->with('error', 'Tagihan belum lunas.');
        }

        return view('finance.receipt', compact('invoice'));
    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($invoice->status !== 'paid') {
            abort(403, 'Belum lunas!');
        }

        $pdf = Pdf::loadView('finance.receipt_pdf', compact('invoice'));
        return $pdf->download('Kuitansi_' . $invoice->order_id . '.pdf');
    }
}
