<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nexora - Rumah Digital Inspiratif</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
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

    <!-- Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-white/10 px-6 md:px-12 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#"
                class="text-2xl md:text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group pointer-events-auto">
                NEX<span class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">ORA</span>
            </a>

            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ route('katalog') }}"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Katalog</a>
                <a href="/#fitur"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Keunggulan</a>
                <a href="/#testimoni"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Testimoni</a>

                <button id="theme-toggle"
                    class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:scale-110 transition-all shadow-sm focus:outline-none">
                    <svg id="sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z">
                        </path>
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>

                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex items-center space-x-4">
                <button id="theme-toggle-mobile"
                    class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z">
                        </path>
                    </svg>
                </button>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400">Dasbor</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative pt-40 md:pt-60 pb-20 md:pb-32 px-6 md:px-12 min-h-[90vh] flex items-center overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 md:gap-24 items-center relative z-10 w-full">
            <div class="gsap-hero-content text-center lg:text-left">
                <span
                    class="inline-flex items-center space-x-3 px-4 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] md:text-xs font-black uppercase tracking-wider mb-8 md:mb-10 mx-auto lg:mx-0">
                    <span
                        class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-indigo-200 dark:bg-indigo-900 border-2 border-indigo-600 dark:border-indigo-400 animate-pulse"></span>
                    <span>{!! \App\Models\Setting::get('hero_badge', 'Platform Literasi Digital No. 1') !!}</span>
                </span>
                <h1
                    class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 md:mb-10 leading-[1.1] text-slate-900 dark:text-white tracking-tighter">
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

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center -space-x-3 md:-space-x-4">
                            <img src="https://i.pravatar.cc/100?u=12"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-800"
                                alt="Avatar">
                            <img src="https://i.pravatar.cc/100?u=23"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-800"
                                alt="Avatar">
                            <img src="https://i.pravatar.cc/100?u=34"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full border-4 border-white dark:border-slate-800"
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

            <!-- Hero Image -->
            <div class="relative gsap-hero-image hidden lg:block">
                <div class="animate-float">
                    @if (\App\Models\Setting::get('hero_image'))
                        <img src="{{ Storage::url(\App\Models\Setting::get('hero_image')) }}" alt="Nexora Products"
                            class="relative rounded-[50px] shadow-2xl w-full max-w-md mx-auto transform rotate-3 border-[8px] border-white dark:border-slate-800 shadow-indigo-500/20 object-cover aspect-[4/5]">
                    @else
                        <img src="https://antigravity-artifacts.s3.amazonaws.com/generated_ebooks_mockup.webp"
                            alt="Nexora Mockup"
                            class="relative rounded-[50px] shadow-2xl w-full max-w-md mx-auto transform rotate-3 border-[8px] border-white dark:border-slate-800 shadow-indigo-500/20">
                    @endif
                </div>
                <!-- Floating Element -->
                <div
                    class="absolute -left-12 top-1/3 p-6 rounded-[32px] bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl border border-slate-100 dark:border-white/10 shadow-2xl max-w-[200px]">
                    <div class="flex items-center space-x-3 mb-2">
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-black text-slate-900 dark:text-white">Kualitas HQ</p>
                    </div>
                    <p class="text-[10px] text-slate-500 font-medium">Semua aset digital dioptimalkan untuk pengalaman
                        baca terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="py-10 px-6 md:px-12 bg-slate-50 dark:bg-white/[0.02]">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-center lg:justify-between gap-10 md:gap-16 items-center">
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-4xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">99%</h4>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Kepuasan
                    Pelanggan</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-4xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">12Rb</h4>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Pembaca
                    Aktif</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-4xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">24/7</h4>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Akses Beli
                    Instan</p>
            </div>
            <div class="gsap-stat text-center lg:text-left">
                <h4 class="text-4xl md:text-5xl font-black text-indigo-600 dark:text-indigo-400">Free</h4>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-500 mt-1">Pembaruan
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
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $f->icon ?? 'M13 10V3L4 14h7v7l9-11h-7z' }}"></path>
                        </svg>
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
                    $testimonials = \App\Models\Testimonial::all();
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

    <!-- GSAP Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme Toggle Logic
            const syncThemeToggle = () => {
                const root = document.getElementById('app-html');
                const isDark = root.classList.contains('dark');
                document.querySelectorAll('#sun-icon').forEach(icon => isDark ? icon.classList.remove(
                    'hidden') : icon.classList.add('hidden'));
                document.querySelectorAll('#moon-icon').forEach(icon => isDark ? icon.classList.add('hidden') :
                    icon.classList.remove('hidden'));
            };

            const toggleTheme = () => {
                const root = document.getElementById('app-html');
                const isDark = !root.classList.contains('dark');
                isDark ? root.classList.add('dark') : root.classList.remove('dark');
                localStorage.theme = isDark ? 'dark' : 'light';
                syncThemeToggle();
            };

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                document.getElementById('app-html').classList.add('dark');
            }
            syncThemeToggle();

            document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);
            document.getElementById('theme-toggle-mobile')?.addEventListener('click', toggleTheme);

            // GSAP Animations Registration
            gsap.registerPlugin(ScrollTrigger);

            // Hero Animation
            const tl = gsap.timeline();
            tl.fromTo(".gsap-hero-content > *", {
                    y: 30,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: "power3.out"
                })
                .fromTo(".gsap-hero-image", {
                        scale: 0.9,
                        opacity: 0,
                        rotation: -5
                    }, {
                        scale: 1,
                        opacity: 1,
                        rotation: 0,
                        duration: 1,
                        ease: "back.out(1.5)"
                    },
                    "-=0.6"
                );

            // Stats Animation
            gsap.fromTo(".gsap-stat", {
                y: 20,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 0.6,
                stagger: 0.1,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".gsap-stat",
                    start: "top 85%"
                }
            });

            // Features Animation
            gsap.fromTo(".gsap-feature-card", {
                y: 40,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#fitur",
                    start: "top 75%"
                }
            });

            // Testimonials Animation
            gsap.fromTo(".gsap-testi-card", {
                y: 40,
                opacity: 0,
                scale: 0.95
            }, {
                y: 0,
                opacity: 1,
                scale: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#testimoni",
                    start: "top 75%"
                }
            });

            // Generic Reveal Sections
            gsap.utils.toArray('.gsap-reveal-section').forEach(section => {
                gsap.fromTo(section, {
                    y: 30,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: section,
                        start: "top 85%",
                    }
                });
            });
        });
    </script>
</body>

</html>
