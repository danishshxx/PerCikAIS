<!DOCTYPE html>
<html>
<head>
    <title>Kuitansi PerCikAIS</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { border-bottom: 2px solid #3B82F6; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { font-size: 18px; font-weight: bold; color: #3B82F6; }
        .lunas { color: green; font-weight: bold; border: 2px solid green; padding: 5px; text-align: center; width: 100px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="title">PerCikAIS PErC</span>
        <p style="margin: 0; font-size: 12px; color: #666;">Institut Teknologi & Bisnis Cikini</p>
    </div>

    <h3>KUITANSI PEMBAYARAN</h3>
    <p><strong>No. Transaksi:</strong> {{ $invoice->order_id }}</p>
    <p><strong>Diterima Dari:</strong> {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
    <p><strong>Tanggal Lunas:</strong> {{ $invoice->updated_at->format('d/m/Y H:i') }}</p>

    <table>
        <tr>
            <th>Deskripsi Tagihan</th>
            <th style="text-align: right;">Jumlah</th>
        </tr>
        <tr>
            <td>{{ $invoice->description }}</td>
            <td style="text-align: right;">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">TOTAL DIBAYAR</td>
            <td class="total" style="text-align: right;">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <br><br>
    <div class="lunas">LUNAS</div>
    <p style="font-size: 10px; color: #999; margin-top: 30px;">Dokumen ini dihasilkan otomatis oleh sistem dan sah tanpa tanda tangan.</p>
</body>
</html>