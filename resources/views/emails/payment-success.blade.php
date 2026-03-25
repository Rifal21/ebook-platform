<x-mail::message>
# Alhamdulillah! Pembayaran Diterima

Halo **{{ $order->user->name }}**,

Pembayaran Anda untuk pesanan **#{{ $order->invoice_number }}** telah berhasil kami terima.

<x-mail::panel>
### Konfirmasi Penyerahan Produk
Dengan ini kami (Pihak NEXORA) secara resmi menyerahkan hak akses penuh atas E-Book **{{ $order->ebook->title }}** kepada Anda, dan kami telah menerima pembayaran lunas senilai **Rp {{ number_format($order->total_amount, 0, ',', '.') }}**. Semoga E-Book ini bermanfaat bagi perjalanan belajar Anda.
</x-mail::panel>

Sekarang Anda dapat mengakses dan mengunduh E-Book Anda melalui halaman transaksi di platform kami:

<x-mail::button :url="route('transactions')" color="success">
Download E-Book Sekarang
</x-mail::button>

Terima kasih telah mempercayai Nexora sebagai teman belajar Anda.

Salam hangat,<br>
{{ config('app.name') }} Team
</x-mail::message>
