<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('finance.index', compact('invoices'));
    }

    // Simulasi tombol Bayar dipencet
    public function pay(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Di sini harusnya nembak API Midtrans, tapi kita simulasi sukses aja
        $invoice->update(['status' => 'paid']);

        return back()->with('success', 'Pembayaran Berhasil! Status tagihan Anda kini LUNAS.');
    }
}