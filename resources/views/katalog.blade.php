<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Nexora</title>
    
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
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.5s ease;
            min-height: 100vh;
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
    </style>
</head>

<body
    class="antialiased selection:bg-indigo-500/30 overflow-x-hidden bg-slate-50 dark:bg-[#020617] text-slate-900 dark:text-slate-100">
    <div class="bg-glow">
        <div class="glow-1 animate-pulse"></div>
        <div class="glow-2 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
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
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center bg-white/40 dark:bg-slate-900/40 backdrop-blur-2xl border border-white/20 dark:border-white/5 px-8 py-3 rounded-full space-x-8 shadow-sm">
                <a href="/" class="text-[11px] font-black text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white uppercase tracking-[2.5px] transition-all relative group">
                    Beranda
                </a>
                <a href="{{ route('katalog') }}" class="text-[11px] font-black text-indigo-600 dark:text-white uppercase tracking-[2.5px] transition-all relative group">
                    Katalog
                    <span class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-full h-0.5 bg-indigo-600 rounded-full"></span>
                </a>
            </div>

            <!-- CTA Buttons & Theme Toggle -->
            <div class="hidden md:flex items-center space-x-6">
                <button id="theme-toggle" class="p-3 w-12 h-12 flex items-center justify-center rounded-2xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-white/10 text-slate-500 hover:scale-110 transition-all shadow-sm">
                    <i id="sun-icon" class="fa-solid fa-sun text-lg hidden"></i>
                    <i id="moon-icon" class="fa-solid fa-moon text-lg"></i>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3.5 rounded-2xl bg-indigo-600 text-white text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-indigo-600/20">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="group relative px-8 py-3.5 rounded-2xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-[11px] font-black uppercase tracking-widest shadow-xl shadow-slate-900/10 overflow-hidden">
                        <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative group-hover:text-white transition-colors duration-300">Mulai Baca</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="md:hidden relative z-50 w-12 h-12 flex items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/50 dark:border-white/10 rounded-2xl shadow-sm text-slate-500 transition-all">
                <i id="hamburger-icon" class="fa-solid fa-bars text-xl transition-all duration-300"></i>
                <i id="close-icon" class="fa-solid fa-xmark text-xl absolute opacity-0 scale-50 transition-all duration-300"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="fixed inset-x-0 top-0 pt-28 pb-10 px-8 bg-white/95 dark:bg-slate-950/95 backdrop-blur-2xl -translate-y-full transition-all duration-700 border-b border-slate-200 dark:border-white/5 shadow-2xl z-40">
            <div class="flex flex-col space-y-8">
                <a href="/" class="text-2xl font-black text-slate-400">Beranda</a>
                <a href="{{ route('katalog') }}" class="text-2xl font-black text-indigo-600">Katalog</a>
                <div class="pt-6 border-t border-slate-100 dark:border-white/5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-center text-xs uppercase tracking-widest">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black text-center text-xs uppercase tracking-widest">Mulai Baca</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Katalog Page Content -->
    <main class="pt-32 pb-20 min-h-screen">
        <livewire:welcome.katalog />
    </main>

    <!-- Footer -->
    <footer
        class="py-16 md:py-24 px-6 md:px-12 bg-white dark:bg-slate-900/50 border-t border-slate-100 dark:border-white/5 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <a href="/" class="text-3xl font-black tracking-tighter text-indigo-900 dark:text-white mb-6 block">
                NEX<span class="text-indigo-600">ORA</span>
            </a>
            <p class="text-[10px] md:text-sm font-bold text-slate-400 dark:text-slate-600">© 2026 Nexora Platform.
                Desain Eksklusif oleh Rifal Kurniawan.</p>
        </div>
    </footer>

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
        })();
    </script>
</body>

</html>
