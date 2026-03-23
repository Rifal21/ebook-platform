<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selesaikan Pembayaran - Nexora</title>
    
    <!-- Theme Management -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; transition: background-color 0.5s ease; min-height: 100vh; }
        .text-gradient { background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-glow { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; pointer-events: none; overflow: hidden; }
        .glow-1 { position: absolute; top: -10%; left: -10%; width: 60%; height: 60%; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%); }
        .glow-2 { position: absolute; bottom: -10%; right: -10%; width: 60%; height: 60%; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); }
        .dark .glow-1 { background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%); }
        .dark .glow-2 { background: radial-gradient(circle, rgba(15, 23, 42, 1) 0%, transparent 70%); }
    </style>
</head>

<body class="antialiased selection:bg-indigo-500/30 overflow-x-hidden bg-slate-50 dark:bg-[#020617] text-slate-900 dark:text-slate-100">
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Modern Floating & Professional Navbar -->
    <nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-6 md:px-12 py-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center transition-all duration-500">
            <!-- Logo -->
            <a href="/" class="relative z-50 text-2xl md:text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group pointer-events-auto">
                <span class="relative">
                    NEX<span class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-1 bg-indigo-600 group-hover:w-full transition-all duration-300 rounded-full"></span>
                </span>
            </a>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('katalog') }}" class="text-[11px] font-black text-slate-500 hover:text-indigo-600 uppercase tracking-widest hidden md:block">Batal & Kembali</a>
                <button id="theme-toggle" class="p-3 w-12 h-12 flex items-center justify-center rounded-2xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-white/10 text-slate-500 hover:scale-110 transition-all shadow-sm">
                    <i id="sun-icon" class="fa-solid fa-sun text-lg hidden"></i>
                    <i id="moon-icon" class="fa-solid fa-moon text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-24 px-6 md:px-12 min-h-screen">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16 md:mb-24 reveal active">
                <span class="inline-flex items-center space-x-3 px-6 py-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-[2px] mb-8">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 dark:bg-indigo-400 animate-pulse"></span>
                    <span>Tinggal Satu Langkah Lagi</span>
                </span>
                <h2 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tighter">Selesaikan <br class="md:hidden"> <span class="text-indigo-600">Pembayaran</span></h2>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-8 md:gap-12">
                <!-- Detail Produk -->
                <div class="w-full lg:w-3/5 space-y-8">
                    <div class="p-10 rounded-[50px] bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 shadow-sm reveal active">
                        <div class="flex flex-col md:flex-row items-start md:space-x-10 space-y-8 md:space-y-0 pb-10 border-b border-slate-100 dark:border-white/5">
                            <div class="relative group mx-auto md:mx-0">
                                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-[35px] blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                                @if($ebook->cover_image)
                                    <div class="relative w-40 aspect-[3/4] overflow-hidden rounded-[30px] shadow-2xl">
                                        <img src="{{ Storage::url($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="relative w-40 aspect-[3/4] bg-slate-100 dark:bg-slate-800 rounded-[30px] flex items-center justify-center border border-slate-200 dark:border-white/5">
                                        <span class="text-slate-400 font-black text-3xl">NEX</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-black text-[10px] uppercase tracking-widest mb-4">{{ $ebook->category?->name ?? 'Digital Product' }}</span>
                                <h4 class="text-3xl font-black text-slate-900 dark:text-white mb-4 leading-tight">{{ $ebook->title }}</h4>
                                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-0">{{ Str::limit($ebook->description, 120) }}</p>
                            </div>
                        </div>

                        <!-- Platform Benefits -->
                        <div class="pt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center space-x-5 p-4 rounded-3xl bg-slate-50 dark:bg-white/5 transition-all hover:scale-[1.02]">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                    <i class="fa-solid fa-bolt text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 dark:text-white text-xs uppercase tracking-widest mb-1">Akses Kilat</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">Produk langsung aktif.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-5 p-4 rounded-3xl bg-slate-50 dark:bg-white/5 transition-all hover:scale-[1.02]">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                    <i class="fa-solid fa-shield-halved text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 dark:text-white text-xs uppercase tracking-widest mb-1">Terproteksi</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">Transaksi 100% aman.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Simple Card for Summary -->
                <div class="w-full lg:w-2/5">
                    <div class="p-10 rounded-[50px] bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 shadow-2xl reveal active sticky top-28">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-8">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-5 mb-8 pb-8 border-b border-slate-100 dark:border-white/5">
                            <div class="flex justify-between items-center px-2">
                                <span class="text-slate-500 dark:text-slate-400 font-bold text-xs uppercase tracking-widest">Harga Dasar</span>
                                <span class="font-black text-slate-900 dark:text-white">Rp {{ number_format($ebook->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <span class="text-slate-500 dark:text-slate-400 font-bold text-xs uppercase tracking-widest">Pajak (0%)</span>
                                <span class="font-black text-emerald-500">GRATIS</span>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-white/5 p-6 rounded-3xl mb-8 flex justify-between items-center">
                            <span class="text-slate-500 dark:text-slate-400 font-black uppercase tracking-[2px] text-[10px]">TOTAL</span>
                            <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($ebook->price, 0, ',', '.') }}</span>
                        </div>

                        <form id="checkout-form" class="space-y-6">
                            <div class="p-6 rounded-3xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 group transition-all">
                                <label class="flex items-start space-x-4 cursor-pointer">
                                    <div class="relative flex items-center mt-1">
                                        <input type="checkbox" id="terms" name="terms" required
                                            class="w-6 h-6 rounded-xl border-slate-300 dark:border-white/10 text-indigo-600 focus:ring-0 focus:ring-offset-0 dark:bg-slate-950 transition-all cursor-pointer">
                                    </div>
                                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed group-hover:text-slate-800 dark:group-hover:text-white transition-colors">
                                        Saya menyetujui <button type="button" id="open-tnc" class="text-indigo-600 dark:text-indigo-400 hover:underline">Syarat & Ketentuan</button> yang berlaku.
                                    </span>
                                </label>
                            </div>

                            <button type="button" id="pay-button" disabled
                                class="w-full py-6 rounded-[28px] relative overflow-hidden text-white font-black text-xs uppercase tracking-[3px] transition-all active:scale-95 shadow-xl disabled:opacity-50 disabled:cursor-not-allowed group bg-slate-900 dark:bg-indigo-600 shadow-slate-900/20 dark:shadow-indigo-600/30">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:not-disabled:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">Bayar Sekarang</span>
                            </button>
                            <p id="error-message" class="text-rose-500 font-black text-[10px] text-center hidden p-4 rounded-2xl bg-rose-50 dark:bg-rose-500/10 uppercase tracking-widest"></p>
                        </form>
                        
                        <!-- Midtrans Info -->
                        <div class="mt-10 pt-8 border-t border-slate-100 dark:border-white/5 text-center">
                            <div class="flex items-center justify-center space-x-2 text-slate-400 mb-2">
                                <i class="fa-solid fa-lock text-[10px]"></i>
                                <span class="text-[9px] font-black uppercase tracking-[2px]">Secured by Midtrans</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- T&C Modal -->
    <div id="tnc-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity" id="tnc-backdrop"></div>
        <div class="fixed inset-0 flex items-center justify-center p-6">
            <div class="bg-white dark:bg-slate-950 w-full max-w-2xl rounded-[40px] shadow-2xl relative flex flex-col max-h-[80vh] border border-white/10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="tnc-content">
                <div class="p-8 flex justify-between items-center border-b border-white/5">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">Terms of <span class="text-indigo-600">Service</span></h3>
                    <button id="close-tnc" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-white/5 text-slate-500 hover:text-rose-500 transition-all">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <div class="p-10 overflow-y-auto no-scrollbar flex-1 text-slate-500 dark:text-slate-400 space-y-8 text-sm leading-relaxed">
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-3 uppercase text-xs tracking-[2px] text-indigo-600">1. Lisensi Penggunaan</h4>
                        <p>Produk digital ini hanya untuk penggunaan pribadi. Dilarang keras melakukan redistribusi, modifikasi, atau komersialisasi ulang tanpa izin tertulis dari Nexora.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-3 uppercase text-xs tracking-[2px] text-indigo-600">2. Kebijakan Refund</h4>
                        <p>Mengingat sifat produk digital yang tidak dapat dikembalikan secara fisik, kami tidak melayani pengembalian dana (refund) setelah akses produk diberikan.</p>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 dark:text-white mb-3 uppercase text-xs tracking-[2px] text-indigo-600">3. Tanggung Jawab Akun</h4>
                        <p>Keamanan akun untuk mengakses produk adalah tanggung jawab penuh pengguna. Nexora tidak bertanggung jawab atas penyalahgunaan akun oleh pihak ketiga.</p>
                    </div>
                </div>
                <div class="p-8 border-t border-white/5 bg-slate-50 dark:bg-white/5 flex justify-end">
                    <button id="accept-tnc" class="w-full md:w-auto px-10 py-4 bg-indigo-600 text-white rounded-[20px] font-black text-xs uppercase tracking-widest shadow-xl shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all">SAYA SETUJU</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        (function() {
            const root = document.documentElement;
            const themeBtn = document.getElementById('theme-toggle');
            
            // 1. Theme Logic
            const syncTheme = () => {
                const isDark = root.classList.contains('dark');
                document.querySelectorAll('#sun-icon').forEach(icon => isDark ? icon.classList.remove('hidden') : icon.classList.add('hidden'));
                document.querySelectorAll('#moon-icon').forEach(icon => isDark ? icon.classList.add('hidden') : icon.classList.remove('hidden'));
            };

            const toggleTheme = () => {
                root.classList.toggle('dark');
                const isDark = root.classList.contains('dark');
                localStorage.theme = isDark ? 'dark' : 'light';
                syncTheme();
            };

            if (themeBtn) {
                themeBtn.onclick = toggleTheme;
            }
            syncTheme();

            // 2. Navbar Scroll
            const nav = document.getElementById('main-nav');
            const handleScroll = () => {
                if (window.scrollY > 50) {
                    nav?.classList.add('py-4', 'bg-white/80', 'dark:bg-[#020617]/80', 'backdrop-blur-2xl', 'border-b', 'border-slate-200/50', 'dark:border-white/5', 'shadow-sm');
                    nav?.classList.remove('py-6');
                } else {
                    nav?.classList.remove('py-4', 'bg-white/80', 'dark:bg-[#020617]/80', 'backdrop-blur-2xl', 'border-b', 'border-slate-200/50', 'dark:border-white/5', 'shadow-sm');
                    nav?.classList.add('py-6');
                }
            };
            window.addEventListener('scroll', handleScroll);
            handleScroll();

            // 3. Checkout Logic
            const termsBox = document.getElementById('terms');
            const payButton = document.getElementById('pay-button');
            const openTncBtn = document.getElementById('open-tnc');
            const closeTncBtn = document.getElementById('close-tnc');
            const acceptTncBtn = document.getElementById('accept-tnc');
            const modal = document.getElementById('tnc-modal');
            const modalContent = document.getElementById('tnc-content');

            if (termsBox && payButton) {
                const updateButtonState = () => {
                    payButton.disabled = !termsBox.checked;
                };
                termsBox.onchange = updateButtonState;
            }

            const showModal = () => {
                modal?.classList.remove('hidden');
                setTimeout(() => {
                    modalContent?.classList.remove('scale-95', 'opacity-0');
                    modalContent?.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            const closeModal = () => {
                modalContent?.classList.remove('scale-100', 'opacity-100');
                modalContent?.classList.add('scale-95', 'opacity-0');
                setTimeout(() => modal?.classList.add('hidden'), 300);
            };

            if (openTncBtn) openTncBtn.onclick = showModal;
            if (closeTncBtn) closeTncBtn.onclick = closeModal;
            if (acceptTncBtn) {
                acceptTncBtn.onclick = () => {
                    if (termsBox) termsBox.checked = true;
                    if (payButton && termsBox) payButton.disabled = false;
                    closeModal();
                };
            }
        })();
    </script>

    <!-- Midtrans Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.getElementById('pay-button')?.addEventListener('click', async function () {
            const btn = this;
            const errorElement = document.getElementById('error-message');
            errorElement.classList.add('hidden');
            
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

            try {
                const response = await fetch("{{ route('checkout.process', $ebook->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ terms: true })
                });

                const data = await response.json();

                if (response.ok && data.redirect && data.payment_url) {
                    // Open Midtrans in new tab
                    window.open(data.payment_url, '_blank');
                    // Redirect current tab to transactions
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.error || 'Server error occurred');
                }
            } catch (error) {
                errorElement.innerText = error.message;
                errorElement.classList.remove('hidden');
                btn.disabled = false;
                btn.innerHTML = `<span class="relative z-10">Bayar Sekarang</span>`;
            }
        });
    </script>
</body>
</html>

