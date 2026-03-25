<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nexora - Rumah Digital Inspiratif</title>
    
    <!-- Theme Management (Must be as high as possible to avoid flash) -->
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
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.5s ease;
            min-height: 100vh;
        }

        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gsap-reveal {
            opacity: 0;
            visibility: hidden;
            will-change: transform, opacity;
        }

        .bg-glow {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            pointer-events: none;
            overflow: hidden;
        }

        .glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
        }

        .glow-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        }

        .dark .glow-1 {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%);
        }

        .dark .glow-2 {
            background: radial-gradient(circle, rgba(15, 23, 42, 1) 0%, transparent 70%);
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(1deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
    </style>
</head>

<body
    class="antialiased selection:bg-indigo-500/30 overflow-x-hidden bg-white dark:bg-[#020617] text-slate-900 dark:text-slate-100">
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Modern Floating & Professional Navbar -->
    <nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-6 md:px-12 py-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center transition-all duration-500">
            <!-- Logo with modern touch -->
            <a href="/"
                class="relative z-50 text-2xl md:text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group pointer-events-auto">
                <span class="relative">
                    NEX<span
                        class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-1 bg-indigo-600 group-hover:w-full transition-all duration-300 rounded-full"></span>
                </span>
            </a>

            <!-- Desktop Menu: Elevated & Minimal -->
            <div
                class="hidden lg:flex items-center bg-white/40 dark:bg-slate-900/40 backdrop-blur-2xl border border-white/20 dark:border-white/5 px-8 py-3 rounded-full space-x-8 shadow-sm">
                <a href="{{ route('katalog') }}"
                    class="text-[11px] font-black text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white uppercase tracking-[2.5px] transition-all relative group">
                    Katalog
                    <span
                        class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 rounded-full"></span>
                </a>
                <a href="#keunggulan"
                    class="text-[11px] font-black text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white uppercase tracking-[2.5px] transition-all relative group">
                    Keunggulan
                    <span
                        class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 rounded-full"></span>
                </a>
                <a href="#testimoni"
                    class="text-[11px] font-black text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white uppercase tracking-[2.5px] transition-all relative group">
                    Testimoni
                    <span
                        class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300 rounded-full"></span>
                </a>
            </div>

                <button id="theme-toggle"
                    class="p-3 w-12 h-12 flex items-center justify-center rounded-2xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-white/10 text-slate-500 hover:scale-110 transition-all shadow-sm">
                    <i id="sun-icon" class="fa-solid fa-sun text-lg hidden"></i>
                    <i id="moon-icon" class="fa-solid fa-moon text-lg"></i>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-8 py-3.5 rounded-2xl bg-indigo-600 text-white text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-indigo-600/20">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="group relative px-8 py-3.5 rounded-2xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-[11px] font-black uppercase tracking-widest shadow-xl shadow-slate-900/10 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        </div>
                        <span class="relative group-hover:text-white transition-colors duration-300">Mulai Baca</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button (Modern Hamburger) -->
            <button id="mobile-menu-toggle"
                class="md:hidden relative z-50 w-12 h-12 flex items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-white/10 rounded-2xl shadow-sm text-slate-500 hover:text-indigo-600 transition-all">
                <i id="hamburger-icon" class="fa-solid fa-bars text-xl transition-all duration-300"></i>
                <i id="close-icon" class="fa-solid fa-xmark text-xl absolute opacity-0 scale-50 transition-all duration-300"></i>
            </button>
        </div>

        <!-- Mobile Menu Overlay (Modern Full-Width Slide) -->
        <div id="mobile-menu"
            class="fixed inset-x-0 top-0 pt-28 pb-10 px-8 bg-white/95 dark:bg-slate-950/95 backdrop-blur-2xl -translate-y-full transition-all duration-700 border-b border-slate-200 dark:border-white/5 shadow-2xl z-40">
            <div class="flex flex-col space-y-8">
                <a href="{{ route('katalog') }}"
                    class="mobile-link text-2xl font-black text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">Katalog</a>
                <a href="#keunggulan"
                    class="mobile-link text-2xl font-black text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">Keunggulan</a>
                <a href="#testimoni"
                    class="mobile-link text-2xl font-black text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors">Testimoni</a>

                <div class="pt-6 border-t border-slate-100 dark:border-white/5">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="w-full py-5 px-4 bg-indigo-600 text-white rounded-2xl font-black text-center text-xs uppercase tracking-widest shadow-xl shadow-indigo-600/20">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-center text-xs uppercase tracking-widest shadow-2xl">Mulai
                            Baca Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative pt-40 md:pt-60 pb-20 md:pb-32 px-6 md:px-12 min-h-[90vh] flex items-center overflow-hidden">

        <!-- Full Bleed Right Background -->
        <div class="absolute inset-y-0 right-0 w-full lg:w-[55%] z-0 gsap-hero-bg overflow-hidden">
            @if (\App\Models\Setting::get('hero_image'))
                <img src="{{ Storage::url(\App\Models\Setting::get('hero_image')) }}" alt="Nexora Products"
                    class="w-full h-full object-cover object-center lg:object-left-top opacity-30 lg:opacity-100">
            @else
                <img src="https://images.unsplash.com/photo-1555099962-4199c345e5dd?q=80&w=2670&auto=format&fit=crop"
                    alt="Nexora Platform"
                    class="w-full h-full object-cover object-center lg:object-left-top opacity-30 lg:opacity-100">
            @endif

            <!-- Dynamic Gradient: Desktop (Side-Fade) vs Mobile (Full-Overlay) -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent dark:from-[#020617] dark:via-[#020617]/80 dark:to-transparent lg:via-white/20 lg:dark:via-[#020617]/20">
            </div>

            <!-- Left focal fade for text readability on desktop -->
            <div
                class="absolute inset-y-0 left-0 w-1/2 bg-gradient-to-r from-white to-transparent dark:from-[#020617] dark:to-transparent hidden lg:block">
            </div>

            <!-- Mobile Bottom Fade to merge with next section -->
            <div
                class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-white dark:from-[#020617] to-transparent">
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto relative z-10 w-full flex">
            <div class="gsap-hero-content text-center lg:text-left w-full lg:w-[65%] lg:pr-16">
                <span
                    class="inline-flex items-center space-x-3 px-4 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] md:text-xs font-black uppercase tracking-wider mb-8 md:mb-10 mx-auto lg:mx-0 shadow-sm border border-indigo-100 dark:border-indigo-500/20 backdrop-blur-md">
                    <span
                        class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-indigo-200 dark:bg-indigo-900 border-2 border-indigo-600 dark:border-indigo-400 animate-pulse"></span>
                    <span>{!! \App\Models\Setting::get('hero_badge', 'Platform Literasi Digital No. 1') !!}</span>
                </span>
                <h1
                    class="text-5xl md:text-7xl lg:text-[5.5rem] font-black mb-6 md:mb-10 leading-[1.05] text-slate-900 dark:text-white tracking-tighter drop-shadow-sm">
                    {!! \App\Models\Setting::get('hero_title', 'Dimensi <span class="text-gradient">Baru</span> Literasi.') !!}
                </h1>
                <p
                    class="text-lg md:text-2xl text-slate-600 dark:text-slate-400 mb-10 md:mb-12 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                    {!! \App\Models\Setting::get(
                        'hero_subtitle',
                        'Tingkatkan produktivitas & pengetahuan Anda dengan koleksi e-book premium dari kreator dunia.',
                    ) !!}
                </p>
                <div class="flex flex-col sm:flex-row gap-6 items-center justify-center lg:justify-start">
                    <a href="{{ route('katalog') }}"
                        class="w-full sm:w-auto bg-indigo-600 text-white px-10 md:px-12 py-4 md:py-5 rounded-[22px] font-black text-lg md:text-xl hover:bg-indigo-700 shadow-2xl shadow-indigo-500/40 transition-transform active:scale-95 text-center">Eksplorasi
                        Sekarang</a>

                    <div class="flex items-center space-x-4 ml-0 sm:ml-4">
                        <div class="flex items-center -space-x-3 md:-space-x-4">
                            <img src="https://i.pravatar.cc/100?u=12"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-900"
                                alt="Avatar">
                            <img src="https://i.pravatar.cc/100?u=23"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-900"
                                alt="Avatar">
                            <img src="https://i.pravatar.cc/100?u=34"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-900"
                                alt="Avatar">
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-[10px] md:text-xs font-bold text-slate-500 uppercase tracking-widest">
                                Bergabung bersama</p>
                            <p class="text-sm md:text-base font-black text-slate-900 dark:text-white">15,000+ Kreator
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="relative -mt-10 md:-mt-20 z-20 py-10 px-6 md:px-12">
        <div
            class="max-w-7xl mx-auto p-8 md:p-12 bg-white/70 dark:bg-slate-900/40 backdrop-blur-2xl rounded-[40px] border border-slate-200/50 dark:border-white/5 shadow-2xl flex flex-wrap justify-center lg:justify-between gap-10 md:gap-16 items-center">
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-3xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">99%</h4>
                <p class="text-[9px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Kepuasan
                    Pelanggan</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-3xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">12Rb</h4>
                <p class="text-[9px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Pembaca
                    Aktif</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-3xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">24/7</h4>
                <p class="text-[9px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Akses Beli
                    Instan</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-3xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">Free</h4>
                <p class="text-[9px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Pembaruan
                    Buku</p>
            </div>
        </div>
    </section>

    <!-- Featured Release -->
    <div class="gsap-reveal-section">
        <livewire:welcome.featured />
    </div>

    <!-- Keunggulan Section -->
    <section id="fitur" class="py-24 md:py-40 px-6 md:px-12">
        <div class="max-w-7xl mx-auto text-center mb-16 md:mb-24 gsap-reveal-section">
            <h2
                class="text-4xl md:text-5xl lg:text-7xl font-black text-slate-900 dark:text-white mb-6 md:mb-8 text-balance">
                {!! \App\Models\Setting::get('feature_title', 'Kenapa <span class="text-gradient">Nexora?</span>') !!}
            </h2>
            <p class="text-lg md:text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                {!! \App\Models\Setting::get(
                    'feature_subtitle',
                    'Dirancang khusus untuk menghadirkan pengalaman e-commerce produk digital yang profesional dan tanpa hambatan.',
                ) !!}
            </p>
        </div>

        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8 md:gap-12">
            @php
                $features = \App\Models\Feature::all();
            @endphp

            @foreach ($features as $f)
                <div
                    class="gsap-feature-card p-8 md:p-12 rounded-[40px] bg-slate-50 dark:bg-white/[0.03] border border-slate-100 dark:border-white/5 transition-colors hover:bg-white dark:hover:bg-slate-800">
                    <div
                        class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[20px] flex items-center justify-center text-white mb-8 shadow-lg shadow-indigo-500/30">
                        @if(Str::startsWith($f->icon ?? '', 'fa-'))
                            <i class="{{ $f->icon }} text-2xl md:text-3xl"></i>
                        @else
                            <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $f->icon ?? 'M13 10V3L4 14h7v7l9-11h-7z' }}"></path>
                            </svg>
                        @endif
                    </div>
                    <h4 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white mb-4">{{ $f->title }}
                    </h4>
                    <p class="text-slate-500 dark:text-slate-400 font-medium leading-relaxed text-sm md:text-base">
                        {{ $f->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-24 md:py-40 px-6 md:px-12 bg-slate-900 border-y border-white/5 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 md:mb-24 gsap-reveal-section">
                <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 md:mb-10 text-balance">
                    {!! \App\Models\Setting::get('testimonial_title', 'Kredibilitas <span class="text-gradient">Terbukti</span>') !!}
                </h2>
                <p class="text-slate-400 max-w-xl mx-auto">Kami bangga menjadi bagian dari perjalanan ribuan kreator
                    dan pembaca di seluruh Indonesia.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @php
                    $testimonials = \App\Models\Testimonial::where('is_approved', true)->get();
                @endphp

                @foreach ($testimonials as $t)
                    <div class="gsap-testi-card p-8 md:p-10 rounded-[35px] bg-white/5 border border-white/10 relative">
                        <div
                            class="absolute -top-5 left-8 w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-black text-white text-2xl">
                            “</div>
                        <p class="text-slate-300 text-base md:text-lg font-medium leading-relaxed mb-8 pt-4">
                            "{{ $t->text }}"</p>
                        <div class="flex items-center space-x-4 border-t border-white/10 pt-6">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-emerald-500 flex items-center justify-center font-black text-white text-xs">
                                {{ substr($t->name, 0, 1) }}</div>
                            <div>
                                <p class="text-white font-black text-sm">{{ $t->name }}</p>
                                <p class="text-indigo-400 text-[10px] font-bold uppercase tracking-widest">
                                    {{ $t->role }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 md:py-32 px-6 md:px-12">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center gsap-reveal-section">
            <a href="#"
                class="text-4xl md:text-5xl font-black tracking-tighter text-indigo-900 dark:text-white mb-8 block">
                NEX<span class="text-indigo-600">ORA</span>
            </a>
            <p class="text-lg md:text-xl text-slate-500 dark:text-slate-400 mb-12 max-w-2xl leading-relaxed">
                {!! \App\Models\Setting::get(
                    'footer_text',
                    'Nexora menghubungkan talenta terbaik dengan pengetahuan berkualitas tinggi. Berdedikasi untuk masa depan literasi digital yang lebih baik.',
                ) !!}
            </p>

            <div
                class="flex flex-wrap justify-center gap-6 md:gap-12 mb-16 text-[10px] md:text-xs font-black uppercase tracking-[2px] md:tracking-[3px] text-slate-400">
                <a href="#" class="hover:text-indigo-600 transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Privasi</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Kontak</a>
            </div>

            <div class="w-full h-px bg-slate-100 dark:bg-white/5 mb-10"></div>
            <p class="text-xs md:text-sm font-bold text-slate-400 dark:text-slate-600">© Copyright {{ date('Y') }}
                Nexora.</p>
        </div>
    </footer>

    <!-- GSAP Animations & Interactions -->
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

            // 2. Navbar Scroll Effect
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

            // 3. Mobile Menu Logic
            const menuBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const burgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');
            const mobileLinks = document.querySelectorAll('.mobile-link');
            let isNavOpen = false;

            const toggleNav = () => {
                isNavOpen = !isNavOpen;
                if (isNavOpen) {
                    mobileMenu?.classList.remove('-translate-y-full');
                    burgerIcon?.classList.add('opacity-0', 'scale-50');
                    closeIcon?.classList.remove('opacity-0', 'scale-50');
                    document.body.style.overflow = 'hidden';
                } else {
                    mobileMenu?.classList.add('-translate-y-full');
                    burgerIcon?.classList.remove('opacity-0', 'scale-50');
                    closeIcon?.classList.add('opacity-0', 'scale-50');
                    document.body.style.overflow = 'auto';
                }
            };

            if (menuBtn) menuBtn.onclick = toggleNav;
            mobileLinks.forEach(link => link.onclick = toggleNav);

            // 4. GSAP Animations Registration
            if (typeof gsap !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
                ScrollTrigger.getAll().forEach(st => st.kill());

                const tl = gsap.timeline();
                tl.fromTo(".gsap-hero-content > *", { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: "power3.out" })
                  .fromTo(".gsap-hero-bg", { opacity: 0 }, { opacity: 1, duration: 1.5, ease: "power2.out" }, "-=0.8");

                gsap.fromTo(".gsap-stat", { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: "power2.out", scrollTrigger: { trigger: ".gsap-stat", start: "top 85%" } });

                gsap.utils.toArray('.gsap-reveal-section').forEach(section => {
                    gsap.fromTo(section, { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: "power2.out", scrollTrigger: { trigger: section, start: "top 85%" } });
                });
            }
        })();
    </script>
</body>

</html>
