<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_number }} - Nexora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .invoice-card { border: none; shadow: none; }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">
    <div class="max-w-4xl mx-auto py-12 px-6">
        <!-- Back Button & Print -->
        <div class="no-print flex justify-between items-center mb-8">
            <a href="{{ route('transactions') }}" class="flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-xl shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-print mr-2"></i> Cetak Invoice
            </button>
        </div>

        <!-- Invoice Card -->
        <div class="invoice-card bg-white rounded-[40px] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
            <!-- Header -->
            <div class="bg-slate-900 p-12 text-white flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-black tracking-tighter mb-2">NEX<span class="text-indigo-500">ORA</span></h1>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Platform E-Book Premium</p>
                </div>
                <div class="mt-8 md:mt-0 text-right">
                    <h2 class="text-4xl font-black mb-1">INVOICE</h2>
                    <p class="text-indigo-400 font-mono font-bold">#{{ $order->invoice_number }}</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-12">
                <!-- Info Grid -->
                <div class="grid md:grid-cols-2 gap-12 mb-16">
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Ditagihkan Kepada:</h4>
                        <p class="text-xl font-black text-slate-900">{{ $order->user->name }}</p>
                        <p class="text-slate-500">{{ $order->user->email }}</p>
                    </div>
                    <div class="md:text-right">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Informasi Transaksi:</h4>
                        <p class="text-slate-900 font-bold">Tanggal: <span class="font-medium text-slate-500">{{ $order->created_at->format('d F Y') }}</span></p>
                        <p class="text-slate-900 font-bold">Metode: <span class="font-medium text-slate-500 uppercase">{{ $order->transaction ? str_replace('_', ' ', $order->transaction->payment_method) : 'N/A' }}</span></p>
                        <p class="text-slate-900 font-bold">Status: 
                            @if(in_array($order->status, ['completed', 'paid', 'success']))
                                <span class="text-emerald-500 uppercase">Paid</span>
                            @else
                                <span class="text-amber-500 uppercase">Pending / Unpaid</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <div class="border-t border-slate-100 pt-8 mb-16">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="py-4">E-Book Description</th>
                                <th class="py-4 text-center">Qty</th>
                                <th class="py-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr>
                                <td class="py-8">
                                    <p class="text-xl font-black text-slate-900">{{ $order->ebook->title }}</p>
                                    <p class="text-slate-500 text-sm mt-1">Akses Lifetime & Lisensi Personal</p>
                                </td>
                                <td class="py-8 text-center font-bold text-slate-600">1</td>
                                <td class="py-8 text-right font-black text-slate-900 text-xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary -->
                <div class="flex flex-col items-end">
                    <div class="w-full md:w-80 space-y-4">
                        <div class="flex justify-between items-center text-slate-500 font-bold">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 font-bold">
                            <span>Pajak (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="h-px bg-slate-100 my-4"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-black text-slate-900">Total</span>
                            <span class="text-3xl font-black text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-20 pt-12 border-t border-slate-100">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 text-center md:text-left">Catatan:</h4>
                            <p class="text-xs text-slate-400 leading-relaxed text-center md:text-left">Ini adalah dokumen elektronik yang dihasilkan secara otomatis dan sah tanpa tanda tangan basah. Simpan invoice ini sebagai bukti pembelian yang valid.</p>
                        </div>
                        <div class="no-print">
                             <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 text-3xl">
                                <i class="fa-solid fa-shield-halved"></i>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Accent -->
            <div class="h-4 bg-indigo-600"></div>
        </div>

        <p class="text-center mt-12 text-slate-400 text-xs font-bold uppercase tracking-widest">Powered by Nexora Platform</p>
    </div>
</body>
</html>
