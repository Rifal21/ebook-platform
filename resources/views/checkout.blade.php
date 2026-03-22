<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout | Nexora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; transition: background-color 0.5s ease; min-height: 100vh; }
        .text-gradient { background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-glow { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; pointer-events: none; overflow: hidden; }
        .glow-1 { position: absolute; top: -10%; left: -10%; width: 60%; height: 60%; background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%); }
        .glow-2 { position: absolute; bottom: -10%; right: -10%; width: 60%; height: 60%; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%); }
        .dark .glow-1 { background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%); }
        .dark .glow-2 { background: radial-gradient(circle, rgba(15, 23, 42, 1) 0%, transparent 70%); }
    </style>
</head>

<body class="antialiased selection:bg-indigo-500/30 overflow-x-hidden bg-slate-50 dark:bg-[#020617] text-slate-900 dark:text-slate-100">
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-white/10 px-6 md:px-12 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl md:text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group pointer-events-auto">
                NEX<span class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
            </a>
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="text-sm font-black text-slate-500 hover:text-indigo-600 uppercase tracking-widest hidden md:block">Batal & Kembali</a>
                <button id="theme-toggle" class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:scale-110 transition-all shadow-sm">
                    <svg id="sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"></path></svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <div class="pt-32 pb-24 px-8 min-h-screen">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <span class="inline-flex items-center space-x-3 px-4 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-wider mb-6">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 dark:bg-indigo-400 animate-ping"></span>
                    <span>Tinggal Satu Langkah Lagi</span>
                </span>
                <h2 class="text-5xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight">Selesaikan <span class="text-gradient">Pembayaran</span></h2>
            </div>
            
            <div class="flex flex-col md:flex-row gap-10">
                <!-- Detail Produk -->
                <div class="w-full md:w-3/5">
                    <div class="p-8 rounded-[40px] bg-white/80 dark:bg-slate-900/60 backdrop-blur-xl border border-slate-100 dark:border-white/5 shadow-2xl">
                        <div class="flex items-start space-x-8 pb-8 border-b border-slate-100 dark:border-white/5">
                            @if($ebook->cover_image)
                                <img src="{{ Storage::url($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-32 rounded-2xl shadow-xl transform -rotate-2">
                            @else
                                <div class="w-32 aspect-[3/4] bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-indigo-500 font-bold transform -rotate-2">Buku</div>
                            @endif
                            <div class="flex-1 mt-2">
                                <h4 class="text-2xl font-black text-slate-900 dark:text-white mb-2">{{ $ebook->title }}</h4>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 leading-relaxed">{{ Str::limit($ebook->description, 100) }}</p>
                                <div class="inline-block px-4 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-black text-xs uppercase tracking-widest">{{ $ebook->category?->name ?? 'Digital' }}</div>
                            </div>
                        </div>

                        <!-- Jaminan Platform -->
                        <div class="pt-8">
                            <h4 class="text-lg font-black text-slate-900 dark:text-white mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Jaminan Nexora</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                                    <p class="font-bold text-emerald-700 dark:text-emerald-400 text-sm mb-1">Akses Instan</p>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-500/80">E-Buku langsung masuk ke Dasbor setelah pembayaran terverifikasi.</p>
                                </div>
                                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/30">
                                    <p class="font-bold text-indigo-700 dark:text-indigo-400 text-sm mb-1">Kualitas Premium</p>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-500/80">Resolusi tertinggi yang tajam dan nyaman untuk mata Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan & Pembayaran -->
                <div class="w-full md:w-2/5">
                    <div class="p-8 rounded-[40px] bg-white/80 dark:bg-slate-900/60 backdrop-blur-xl border border-slate-100 dark:border-white/5 shadow-2xl sticky top-28">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-6">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6 pb-6 border-b border-slate-100 dark:border-white/5">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 dark:text-slate-400 font-medium text-sm">Harga E-Book</span>
                                <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($ebook->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 dark:text-slate-400 font-medium text-sm">Pajak Transaksi</span>
                                <span class="font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded text-xs">Gratis</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mb-8 pt-2">
                            <span class="text-slate-500 dark:text-slate-400 font-black uppercase tracking-widest text-xs">Total Pembayaran</span>
                            <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($ebook->price, 0, ',', '.') }}</span>
                        </div>

                        <form id="checkout-form" class="space-y-6">
                            <label class="flex items-start space-x-4 cursor-pointer group p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-white/5 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800/80">
                                <div class="flex-shrink-0 mt-0.5">
                                    <input type="checkbox" id="terms" name="terms" required
                                        class="w-5 h-5 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-900 cursor-pointer">
                                </div>
                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400 leading-relaxed transition-colors">
                                    Saya telah membaca dan menyetujui <button type="button" id="open-tnc" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline focus:outline-none">Syarat & Ketentuan</button> pembelian digital produk ini.
                                </span>
                            </label>

                            <button type="button" id="pay-button" disabled
                                class="w-full py-5 rounded-[20px] relative overflow-hidden text-white font-black text-sm uppercase tracking-widest transition-all active:scale-95 shadow-xl group disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-400 dark:disabled:bg-slate-600 bg-slate-900 dark:bg-indigo-600 shadow-slate-900/10 dark:shadow-indigo-600/20">
                                <div class="absolute inset-0 w-full h-full bg-white/20 scale-x-0 origin-left group-hover:not-disabled:scale-x-100 transition-transform duration-300"></div>
                                <span class="relative">Bayar Sekarang</span>
                            </button>
                            <p id="error-message" class="text-rose-500 font-bold text-xs text-center hidden p-3 rounded-lg bg-rose-50 dark:bg-rose-500/10"></p>
                        </form>
                        
                        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-white/5 flex flex-col items-center">
                            <!-- Secure payment badge visual -->
                            <div class="flex items-center space-x-2 text-slate-400 dark:text-slate-500 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span class="text-xs font-black uppercase tracking-widest">Transaksi 100% Aman</span>
                            </div>
                            <p class="text-[10px] text-slate-400 text-center font-bold">Pembayaran diproses dan dilindungi oleh sistem keamanan berstandar bank dari Midtrans.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- T&C Modal -->
    <div id="tnc-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" id="tnc-backdrop"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[30px] shadow-2xl relative flex flex-col max-h-[90vh] border border-slate-200 dark:border-slate-700 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="tnc-content">
                <div class="p-6 md:p-8 flex justify-between items-center border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white">Syarat & Ketentuan</h3>
                    <button id="close-tnc" class="text-slate-400 hover:text-rose-500 transition-colors bg-white dark:bg-slate-800 p-2 rounded-full shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 md:p-8 overflow-y-auto custom-scrollbar flex-1 text-slate-600 dark:text-slate-400 space-y-6 text-sm lg:text-base leading-relaxed">
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-2 uppercase text-xs tracking-widest text-indigo-600 dark:text-indigo-400">1. Ketentuan Penggunaan (Conditions of Use)</h4>
                        <p>Layanan penjualan E-Book Nexora ditawarkan kepada Anda dengan syarat Anda menerima segala syarat, ketentuan, serta pemberitahuan yang tertera dalam layar ini tanpa terkecuali.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-2 uppercase text-xs tracking-widest text-indigo-600 dark:text-indigo-400">2. Gambaran Umum (Overview)</h4>
                        <p>Mengakses dan membeli dari situs ini berarti Anda menyetujui secara sadar seluruh syarat dan ketentuan yang berlaku. Harap baca secara teliti; jika Anda tidak setuju, Anda diwajibkan untuk meninggalkan situs dan menghentikan proses transaksi cetak maupun digital.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-2 uppercase text-xs tracking-widest text-indigo-600 dark:text-indigo-400">3. Modifikasi Layanan (Modification)</h4>
                        <p>Nexora memegang hak penuh untuk mengganti, mengubah, atau menghentikan tanpa batas waktu segala jenis tautan materi teks/gambar, nominal produk, serta layanan secara sepihak. Segala keputusan perubahan harga adalah mutlak di bawah pengawasan kami. Penggunaan Anda secara berkelanjutan menandakan Anda setuju untuk terikat.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-2 uppercase text-xs tracking-widest text-indigo-600 dark:text-indigo-400">4. Hak Cipta Akses (Copyrights)</h4>
                        <p>Konten E-Book terenkripsi dalam lisensi Personal-Use. Kecuali diizinkan secara tertulis, tidak ada materi buku dari Nexora yang boleh disalin, diciplak, dijual kembali secara komersial, diunggah ulang, maupun dibagikan secara gratis kepada publik luas.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-2 uppercase text-xs tracking-widest text-indigo-600 dark:text-indigo-400">5. Akun & Pendaftaran (Sign Up)</h4>
                        <p>Anda bertanggung jawab penuh untuk menyimpan kerahasiaan kata sandi serta informasi akun pendaftaran (Sign up) Anda demi mendownload (unduh) pembelian produk. Platform tidak bertanggung jawab atas kebocoran produk yang diakibatkan kelalaian pengguna. Tidak ada Refund (Pengembalian Uang) pada produk yang terbeli dan dapat diakses.</p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 text-right">
                        <p class="text-[10px] font-black uppercase tracking-widest">Copyright © Nexora {{ date('Y') }}</p>
                    </div>
                </div>
                <div class="p-6 md:p-8 border-t border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 flex justify-end">
                    <button id="accept-tnc" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black shadow-lg shadow-indigo-600/30 transition-all active:scale-95">SAYA MENGERTI & SETUJU</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            const root = document.getElementById('app-html');

            const applyTheme = (isDark) => {
                if (isDark) {
                    root.classList.add('dark');
                    sunIcon?.classList.remove('hidden');
                    moonIcon?.classList.add('hidden');
                } else {
                    root.classList.remove('dark');
                    sunIcon?.classList.add('hidden');
                    moonIcon?.classList.remove('hidden');
                }
            };

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                applyTheme(true);
            }

            themeToggle?.addEventListener('click', () => {
                const isDark = !root.classList.contains('dark');
                localStorage.theme = isDark ? 'dark' : 'light';
                applyTheme(isDark);
            });
        });
    </script>

    <!-- Midtrans Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const termsBox = document.getElementById('terms');
            const payButton = document.getElementById('pay-button');
            const openTncBtn = document.getElementById('open-tnc');
            const closeTncBtn = document.getElementById('close-tnc');
            const acceptTncBtn = document.getElementById('accept-tnc');
            const backdrop = document.getElementById('tnc-backdrop');
            const modal = document.getElementById('tnc-modal');
            const modalContent = document.getElementById('tnc-content');

            // Handle Checkbox State Enable/Disable
            const updateButtonState = () => {
                if(termsBox.checked) {
                    payButton.removeAttribute('disabled');
                    payButton.classList.add('hover:bg-indigo-700', 'dark:hover:bg-indigo-500');
                } else {
                    payButton.setAttribute('disabled', 'true');
                    payButton.classList.remove('hover:bg-indigo-700', 'dark:hover:bg-indigo-500');
                }
            };

            termsBox.addEventListener('change', updateButtonState);

            // Modal Handlers
            const showModal = () => {
                modal.classList.remove('hidden');
                // trigger animation slightly later for transition
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            const closeModal = () => {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            };

            openTncBtn.addEventListener('click', showModal);
            closeTncBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);
            
            acceptTncBtn.addEventListener('click', () => {
                termsBox.checked = true;
                updateButtonState();
                closeModal();
            });

            // Handle Checkout Submit
            payButton.addEventListener('click', async function () {
                const termsChecked = termsBox.checked;
                const errorElement = document.getElementById('error-message');
                
                errorElement.classList.add('hidden');

            if (!termsChecked) {
                errorElement.innerText = "Centang kotak persetujuan Syarat & Ketentuan untuk melanjutkan.";
                errorElement.classList.remove('hidden');
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span class="relative top-[1px]">MEMPROSES...</span>`;

            try {
                const response = await fetch("{{ route('checkout.process', $ebook->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ terms: true })
                });

                const data = await response.json();

                if (response.ok && data.snapToken) {
                    window.snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            window.location.href = "{{ route('dashboard') }}?payment=success";
                        },
                        onPending: function(result) {
                            window.location.href = "{{ route('dashboard') }}?payment=pending";
                        },
                        onError: function(result) {
                            window.location.href = "{{ route('dashboard') }}?payment=error";
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.innerHTML = `<span class="relative">BAYAR SEKARANG</span>`;
                        }
                    });
                } else {
                    throw new Error(data.error || 'Terjadi kesalahan pada server');
                }
            } catch (error) {
                errorElement.innerText = error.message;
                errorElement.classList.remove('hidden');
                payButton.disabled = false;
                payButton.innerHTML = `<span class="relative">BAYAR SEKARANG</span>`;
            }
        });
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #334155; }
    </style>
</body>
</html>
