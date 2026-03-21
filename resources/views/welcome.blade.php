<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ElitePustaka - Rumah Digital Rifal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
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

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
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
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        }

        .glow-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
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
                transform: translateY(-30px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
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
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-white/10 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="text-3xl font-black tracking-tighter text-indigo-900 dark:text-white group">
                ELITE<span
                    class="text-indigo-600 transition-colors duration-300 group-hover:text-emerald-500">PUSTAKA</span>
            </a>

            <div class="hidden md:flex items-center space-x-10">
                <a href="#katalog"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Katalog</a>
                <a href="#fitur"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Keunggulan</a>
                <a href="#testimoni"
                    class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Testimoni</a>

                <button id="theme-toggle"
                    class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:scale-110 transition-all shadow-sm">
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
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-60 pb-32 px-8 min-h-screen flex items-center overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-24 items-center relative z-10">
            <div class="reveal">
                <span
                    class="inline-flex items-center space-x-3 px-4 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-wider mb-10">
                    <span
                        class="w-4 h-4 rounded-full bg-indigo-200 dark:bg-indigo-900 border-2 border-indigo-600 dark:border-indigo-400 animate-pulse"></span>
                    <span>{!! \App\Models\Setting::get('hero_badge', 'Platform Literasi No. 1 di Indonesia') !!}</span>
                </span>
                <h1
                    class="text-7xl lg:text-9xl font-black mb-10 leading-[1] text-slate-900 dark:text-white tracking-tighter">
                    {!! \App\Models\Setting::get('hero_title', 'Ruang <span class="text-gradient">Imajinasi</span> Tanpa Batas.') !!}
                </h1>
                <p class="text-2xl text-slate-600 dark:text-slate-400 mb-12 leading-relaxed max-w-xl font-medium">
                    {!! \App\Models\Setting::get(
                        'hero_subtitle',
                        'Akses ribuan koleksi e-book premium dari penulis dunia langsung di genggaman Anda.',
                    ) !!}
                </p>
                <div class="flex flex-wrap gap-6 items-center">
                    <a href="#katalog"
                        class="bg-indigo-600 text-white px-12 py-5 rounded-[22px] font-black text-xl hover:bg-indigo-700 shadow-3xl shadow-indigo-500/40 transition-all hover:scale-105 active:scale-95">Mulai
                        Eksplorasi</a>
                    <div class="flex items-center -space-x-4">
                        <img src="https://i.pravatar.cc/100?u=1"
                            class="w-12 h-12 rounded-full border-4 border-white dark:border-slate-800" alt="Avatar">
                        <img src="https://i.pravatar.cc/100?u=2"
                            class="w-12 h-12 rounded-full border-4 border-white dark:border-slate-800" alt="Avatar">
                        <img src="https://i.pravatar.cc/100?u=3"
                            class="w-12 h-12 rounded-full border-4 border-white dark:border-slate-800" alt="Avatar">
                        <div
                            class="w-12 h-12 rounded-full border-4 border-white dark:border-slate-800 bg-emerald-500 flex items-center justify-center text-white text-[10px] font-black">
                            +12k</div>
                    </div>
                </div>
            </div>

            <div class="relative reveal" style="transition-delay: 200ms">
                <div class="animate-float">
                    @if (\App\Models\Setting::get('hero_image'))
                        <img src="{{ Storage::url(\App\Models\Setting::get('hero_image')) }}" alt="Elitebooks"
                            class="relative rounded-[60px] shadow-4xl w-full max-w-xl mx-auto transform rotate-2 border-[12px] border-white dark:border-slate-800 shadow-indigo-500/10 object-cover aspect-[4/5]">
                    @else
                        <img src="https://antigravity-artifacts.s3.amazonaws.com/generated_ebooks_mockup.webp"
                            alt="Elitebooks"
                            class="relative rounded-[60px] shadow-4xl w-full max-w-xl mx-auto transform rotate-2 border-[12px] border-white dark:border-slate-800 shadow-indigo-500/10">
                    @endif
                </div>
                <!-- Floating Info Card -->
                <div class="absolute -right-10 top-1/2 p-8 rounded-[40px] bg-white/80 dark:bg-slate-900/80 backdrop-blur-3xl border border-slate-100 dark:border-white/10 shadow-3xl max-w-[240px] hidden lg:block reveal"
                    style="transition-delay: 400ms">
                    <p class="text-[10px] font-black uppercase text-indigo-600 mb-3">Update Hari Ini</p>
                    <h5 class="text-lg font-black dark:text-white leading-tight mb-4">Mastering AI with Rifal Kurniawan
                    </h5>
                    <p class="text-xs text-slate-500">Baru saja diunggah 2 jam yang lalu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="py-12 px-8">
        <div
            class="max-w-7xl mx-auto flex flex-wrap justify-between gap-12 items-center border-y border-slate-100 dark:border-white/5 py-16">
            <div class="reveal active flex items-center space-x-6">
                <h4 class="text-5xl font-black text-indigo-600">500+</h4>
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Penulis Dunia</p>
            </div>
            <div class="reveal active flex items-center space-x-6" style="transition-delay: 100ms">
                <h4 class="text-5xl font-black text-indigo-600">12Rb</h4>
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Pembaca Sastrawa</p>
            </div>
            <div class="reveal active flex items-center space-x-6" style="transition-delay: 200ms">
                <h4 class="text-5xl font-black text-indigo-600">4.9</h4>
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Rating Rata-rata</p>
            </div>
            <div class="reveal active flex items-center space-x-6" style="transition-delay: 300ms">
                <h4 class="text-5xl font-black text-indigo-600">Free</h4>
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Update Selamanya</p>
            </div>
        </div>
    </section>

    <!-- Featured Release -->
    <livewire:welcome.featured />

    <!-- Katalog -->
    <livewire:welcome.katalog />

    <!-- Keunggulan Section -->
    <section id="fitur" class="py-40 px-8">
        <div class="max-w-7xl mx-auto text-center mb-32 reveal">
            <h2 class="text-5xl lg:text-7xl font-black text-slate-900 dark:text-white mb-10">{!! \App\Models\Setting::get('feature_title', 'Kenapa <span class="text-gradient">ElitePustaka?</span>') !!}
            </h2>
            <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                {!! \App\Models\Setting::get(
                    'feature_subtitle',
                    'Kami menghadirkan pengalaman membaca digital yang jauh lebih eksklusif daripada platform lain.',
                ) !!}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-12">
            @php
                $features = [
                    [
                        'title' => 'Sekali Beli, Milik Sendiri',
                        'desc' =>
                            'Tidak ada biaya langganan bulanan. Cukup beli sekali, simpan di koleksi Anda selamanya.',
                        'icon' =>
                            'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1',
                    ],
                    [
                        'title' => 'Kualitas HD & Jernih',
                        'desc' =>
                            'Setiap file e-book dioptimalkan untuk berbagai layar, dari smartphone hingga tablet e-ink.',
                        'icon' =>
                            'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    ],
                    [
                        'title' => 'Terjemahan Akurat',
                        'desc' =>
                            'Koleksi e-book mancanegara kami memiliki terjemahan Indonesia berkualitas tinggi & mudah dipahami.',
                        'icon' =>
                            'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129',
                    ],
                ];
            @endphp

            @foreach ($features as $i => $f)
                <div class="reveal p-12 rounded-[50px] bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 transition-all hover:bg-white dark:hover:bg-slate-900 hover:shadow-2xl hover:scale-105 group"
                    style="transition-delay: {{ $i * 150 }}ms">
                    <div
                        class="w-16 h-16 bg-indigo-600 rounded-3xl flex items-center justify-center text-white mb-10 shadow-xl shadow-indigo-600/20 group-hover:rotate-12 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $f['icon'] }}"></path>
                        </svg>
                    </div>
                    <h4 class="text-3xl font-black text-slate-900 dark:text-white mb-6">{{ $f['title'] }}</h4>
                    <p class="text-slate-500 dark:text-slate-400 font-medium leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-40 px-8 bg-slate-900 border-y border-white/5 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-32 reveal">
                <h2 class="text-5xl lg:text-7xl font-black text-white mb-10">{!! \App\Models\Setting::get('testimonial_title', 'Kisah Sukses <span class="text-gradient">Pembaca</span>') !!}</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                @php
                    $testimonials = [
                        [
                            'name' => 'Faisal Kurniawan',
                            'role' => 'Front-end Developer',
                            'text' =>
                                'Koleksi e-book teknologinya keren-keren! Sangat membantu saya belajar framework baru dengan cepat.',
                        ],
                        [
                            'name' => 'Sarah Amalia',
                            'role' => 'Digital Entrepreneur',
                            'text' =>
                                'ElitePustaka adalah investasi terbaik saya tahun ini. Harganya sangat terjangkau dibanding ilmu yang saya dapat.',
                        ],
                        [
                            'name' => 'Adit Pratama',
                            'role' => 'Mahasiswa Psikologi',
                            'text' =>
                                'Interface-nya sangat mewah dan memanjakan mata. Fitur dark mode-nya juara buat baca malem-malem.',
                        ],
                    ];
                @endphp

                @foreach ($testimonials as $i => $t)
                    <div class="reveal p-10 rounded-[45px] bg-white/5 border border-white/10 relative"
                        style="transition-delay: {{ $i * 100 }}ms">
                        <div
                            class="absolute -top-6 left-10 w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center font-black text-white text-3xl">
                            “</div>
                        <p class="text-slate-300 text-lg italic leading-relaxed mb-8">“{{ $t['text'] }}”</p>
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center font-black text-white text-xs">
                                {{ substr($t['name'], 0, 1) }}</div>
                            <div>
                                <p class="text-white font-black text-sm">{{ $t['name'] }}</p>
                                <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">
                                    {{ $t['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-32 px-8">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <a href="#"
                class="text-5xl font-black tracking-tighter text-indigo-900 dark:text-white mb-10 block">
                ELITE<span class="text-indigo-600">PUSTAKA</span>
            </a>
            <p class="text-xl text-slate-500 dark:text-slate-400 mb-16 max-w-2xl leading-relaxed">
                {!! \App\Models\Setting::get(
                    'footer_text',
                    'ElitePustaka berdedikasi untuk memajukan bangsa Indonesia melalui akses literasi digital yang adil dan berkualitas tinggi.',
                ) !!}</p>

            <div
                class="flex flex-wrap justify-center gap-12 mb-20 text-xs font-black uppercase tracking-[3px] text-slate-400">
                <a href="#" class="hover:text-indigo-600 transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Hubungi Kami</a>
            </div>

            <div class="w-full h-px bg-slate-100 dark:bg-white/5 mb-12"></div>
            <p class="text-sm font-bold text-slate-400 dark:text-slate-600">© 2026 ElitePustaka. Dikelola dengan penuh
                bangga oleh Rifal Kurniawan.</p>
        </div>
    </footer>

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

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)) {
                applyTheme(true);
            }

            themeToggle?.addEventListener('click', () => {
                const isDark = !root.classList.contains('dark');
                localStorage.theme = isDark ? 'dark' : 'light';
                applyTheme(isDark);
            });

            // Intersection Observer untuk reveal
            const reveals = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1
            });

            reveals.forEach(reveal => observer.observe(reveal));
        });
    </script>
</body>

</html>
