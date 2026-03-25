<?php

use App\Models\Setting;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $hero_badge;
    public $hero_title;
    public $hero_subtitle;
    public $hero_image;
    public $feature_title;
    public $feature_subtitle;
    public $testimonial_title;
    public $footer_text;

    public function mount()
    {
        $this->hero_badge = Setting::get('hero_badge', 'Platform Literasi No. 1 di Indonesia');
        $this->hero_title = Setting::get('hero_title', 'Ruang <span class="text-gradient">Imajinasi</span> Tanpa Batas.');
        $this->hero_subtitle = Setting::get('hero_subtitle', 'Akses ribuan koleksi e-book premium dari penulis dunia langsung di genggaman Anda.');
        $this->feature_title = Setting::get('feature_title', 'Kenapa <span class="text-gradient">Nexora?</span>');
        $this->feature_subtitle = Setting::get('feature_subtitle', 'Kami menghadirkan pengalaman membaca digital yang jauh lebih eksklusif daripada platform lain.');
        $this->testimonial_title = Setting::get('testimonial_title', 'Kisah Sukses <span class="text-gradient">Pembaca</span>');
        $this->footer_text = Setting::get('footer_text', 'Nexora berdedikasi untuk memajukan bangsa Indonesia melalui akses literasi digital yang adil dan berkualitas tinggi.');
    }

    public function save()
    {
        $this->validate([
            'hero_badge' => 'required',
            'hero_title' => 'required',
            'hero_subtitle' => 'required',
            'hero_image' => 'nullable|image|max:2048', // 2MB Max
            'feature_title' => 'required',
            'feature_subtitle' => 'required',
            'testimonial_title' => 'required',
            'footer_text' => 'required',
        ]);

        if ($this->hero_image) {
            $imagePath = $this->hero_image->store('settings', 'public');
            Setting::set('hero_image', $imagePath);
        }

        Setting::set('hero_badge', $this->hero_badge);
        Setting::set('hero_title', $this->hero_title);
        Setting::set('hero_subtitle', $this->hero_subtitle);
        Setting::set('feature_title', $this->feature_title);
        Setting::set('feature_subtitle', $this->feature_subtitle);
        Setting::set('testimonial_title', $this->testimonial_title);
        Setting::set('footer_text', $this->footer_text);

        $this->dispatch('settings-saved');
    }
}; ?>

<div
    class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-6 md:p-10 shadow-sm border border-slate-100 dark:border-white/5 relative">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h4 class="text-2xl font-black text-slate-900 dark:text-white">Pengaturan Landing Page</h4>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Sesuaikan teks yang muncul pada halaman utama
                website Anda.</p>
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Hero Section Config -->
        <div
            class="p-6 md:p-8 rounded-[35px] bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 relative">
            <h5 class="text-lg font-black text-indigo-600 dark:text-indigo-400 mb-6 uppercase tracking-widest">Bagian
                Utama (Hero)</h5>
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Badge
                        Teks</label>
                    <input wire:model="hero_badge" type="text"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Judul
                        Utama</label>
                    <input wire:model="hero_title" type="text"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Sub-judul
                        / Deskripsi Singkat</label>
                    <textarea wire:model="hero_subtitle" rows="3"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Gambar
                        Sampul Utama (Hero Mockup)</label>
                    <div class="flex items-center space-x-6">
                        @if (\App\Models\Setting::get('hero_image'))
                            <div
                                class="w-24 h-24 rounded-2xl border-2 border-slate-200 dark:border-white/10 flex-shrink-0 bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0">
                                <img src="{{ Storage::url(\App\Models\Setting::get('hero_image')) }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @else
                            <div
                                class="w-24 h-24 rounded-2xl border-2 border-dashed border-slate-300 dark:border-white/20 flex-shrink-0 flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 shrink-0">
                                <span class="text-xs font-bold text-slate-400">Default</span>
                            </div>
                        @endif
                        <div class="flex-grow">
                            <input wire:model="hero_image" type="file" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 dark:file:bg-indigo-500/10 dark:file:text-indigo-400">
                            <div wire:loading wire:target="hero_image"
                                class="mt-2 text-xs font-bold text-emerald-500 animate-pulse">Mengunggah gambar...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Config -->
        <div
            class="p-6 md:p-8 rounded-[35px] bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 relative">
            <h5 class="text-lg font-black text-emerald-600 dark:text-emerald-400 mb-6 uppercase tracking-widest">Bagian
                Keunggulan</h5>
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Judul
                        Bagian</label>
                    <input wire:model="feature_title" type="text"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Sub-judul
                        Bagian</label>
                    <textarea wire:model="feature_subtitle" rows="2"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Testimonial Config -->
        <div
            class="p-8 rounded-[35px] bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 relative">
            <h5 class="text-lg font-black text-pink-600 dark:text-pink-400 mb-6 uppercase tracking-widest">Bagian
                Testimoni</h5>
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Judul
                        Testimoni</label>
                    <input wire:model="testimonial_title" type="text"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Footer Config -->
        <div
            class="p-8 rounded-[35px] bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 relative">
            <h5 class="text-lg font-black text-orange-600 dark:text-orange-400 mb-6 uppercase tracking-widest">Bagian
                Footer (Bawah)</h5>
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Deskripsi
                        Footer</label>
                    <textarea wire:model="footer_text" rows="2"
                        class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 mt-8 pt-4">
            <span x-data="{ shown: false }"
                x-on:settings-saved.window="shown = true; setTimeout(() => shown = false, 2000)" x-show="shown"
                x-transition class="text-emerald-500 text-sm font-bold mr-4" style="display: none;">Pengaturan berhasil
                disimpan!</span>
            <button type="submit" class="btn-premium px-12 py-4 shadow-xl">SIMPAN PENGATURAN</button>
        </div>
    </form>
</div>
