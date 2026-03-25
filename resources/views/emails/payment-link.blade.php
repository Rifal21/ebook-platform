<x-mail::message>
# Halo {{ $order->user->name }}!

Terima kasih telah melakukan pemesanan di **Nexora**. Pesanan Anda dengan nomor invoice **{{ $order->invoice_number }}** telah berhasil dibuat.

Silahkan lanjutkan pembayaran untuk mendapatkan akses penuh ke E-Book **{{ $order->ebook->title }}**.

<x-mail::panel>
**Detail Pesanan:**
- **Nomor Invoice:** #{{ $order->invoice_number }}
- **E-Book:** {{ $order->ebook->title }}
- **Total Tagihan:** Rp {{ number_format($order->total_amount, 0, ',', '.') }}
</x-mail::panel>

<x-mail::button :url="$order->payment_url" color="success">
Bayar Sekarang
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }} Team
</x-mail::message>

