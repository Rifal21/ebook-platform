<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .header { background-color: #0f172a; color: white; padding: 40px; }
        .invoice-title { font-size: 32px; font-weight: bold; margin-bottom: 5px; }
        .invoice-subtitle { color: #94a3b8; font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        .content { padding: 40px; }
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .info-cell { width: 50%; vertical-align: top; }
        .label { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: bold; margin-bottom: 10px; }
        .value { color: #1e293b; font-weight: bold; font-size: 16px; }
        .status-paid { color: #10b981; text-transform: uppercase; }
        .status-unpaid { color: #f59e0b; text-transform: uppercase; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; border-top: 1px solid #f1f5f9; }
        .items-table th { text-align: left; padding: 15px 0; font-size: 10px; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
        .items-table td { padding: 25px 0; border-bottom: 1px solid #f8fafc; }
        .summary-box { width: 100%; margin-top: 40px; }
        .summary-cell { width: 100%; text-align: right; }
        .total-amount { font-size: 28px; color: #4f46e5; font-weight: bold; }
        .footer { margin-top: 100px; padding-top: 30px; border-top: 1px solid #f1f5f9; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div style="font-size: 24px; font-weight: bold;">NEX<span style="color: #6366f1;">ORA</span></div>
                    <div class="invoice-subtitle">Platform E-Book Premium</div>
                </td>
                <td style="text-align: right;">
                    <div class="invoice-title">INVOICE</div>
                    <div style="color: #6366f1; font-weight: bold; font-family: monospace;">#{{ $order->invoice_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table class="info-grid">
            <tr>
                <td class="info-cell">
                    <div class="label">Ditagihkan Kepada:</div>
                    <div class="value">{{ $order->user->name }}</div>
                    <div style="color: #64748b;">{{ $order->user->email }}</div>
                </td>
                <td class="info-cell" style="text-align: right;">
                    <div class="label">Informasi Transaksi:</div>
                    <div style="font-weight: bold;">Tanggal: <span style="font-weight: normal; color: #64748b;">{{ $order->created_at->format('d F Y') }}</span></div>
                    <div style="font-weight: bold;">Status: 
                        @if(in_array($order->status, ['completed', 'paid', 'success']))
                            <span class="status-paid">Paid</span>
                        @else
                            <span class="status-unpaid">Unpaid</span>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 70%;">Deskripsi Produk</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-size: 18px; font-weight: bold; color: #0f172a;">{{ $order->ebook->title }}</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 5px;">Akses Lifetime & Lisensi Personal Digital</div>
                    </td>
                    <td style="text-align: center; color: #1e293b;">1</td>
                    <td style="text-align: right; font-weight: bold; color: #0f172a; font-size: 18px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-box">
            <table style="width: 100%;">
                <tr>
                    <td></td>
                    <td style="width: 250px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="padding: 10px 0; color: #64748b;">Subtotal</td>
                                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; color: #64748b;">Pajak (0%)</td>
                                <td style="text-align: right; font-weight: bold;">Rp 0</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-top: 1px solid #f1f5f9; padding: 10px 0;"></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; font-weight: bold; font-size: 18px;">Total</td>
                                <td class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="label">Catatan:</div>
                        <div style="width: 350px;">Ini adalah dokumen elektronik resmi yang sah sebagai bukti transaksi yang valid di Nexora Platform. E-book Anda dapat segera diunduh melalui dashboard.</div>
                    </td>
                    <td style="text-align: right; vertical-align: bottom;">
                        &copy; {{ date('Y') }} Nexora. All Rights Reserved.
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
