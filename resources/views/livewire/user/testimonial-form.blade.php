<?php

use App\Models\Testimonial;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $text = '';
    public $role = '';
    public $successMessage = '';

    public function mount()
    {
        $existing = Testimonial::where('user_id', Auth::id())->first();
        if ($existing) {
            $this->text = $existing->text;
            $this->role = $existing->role;
        }
    }

    public function save()
    {
        $this->validate([
            'text' => 'required|min:10|max:500',
            'role' => 'nullable|max:50',
        ]);

        Testimonial::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => Auth::user()->name,
                'text' => $this->text,
                'role' => $this->role ?? 'Happy Reader',
                'is_approved' => false, // Reset approval on edit
            ]
        );

        $this->successMessage = 'Testimoni Anda telah disimpan dan menunggu persetujuan admin.';
    }
}; ?>

<div class="bg-white dark:bg-slate-900 rounded-[40px] p-8 md:p-12 border border-slate-100 dark:border-white/5 shadow-sm">
    <div class="flex items-center space-x-4 mb-8">
        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-xl">
            <i class="fa-solid fa-comment-dots"></i>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white">Beri Testimoni</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Bagikan pengalaman Anda menggunakan Nexora.</p>
        </div>
    </div>

    @if ($successMessage)
        <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl flex items-start space-x-4">
            <div class="w-10 h-10 bg-emerald-500 rounded-2xl flex items-center justify-center text-white flex-shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <p class="text-emerald-500 font-bold">{{ $successMessage }}</p>
                <p class="text-emerald-500/70 text-sm">Terima kasih atas dukungannya!</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        <div class="space-y-4">
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Apa pendapat Anda?</label>
            <textarea 
                wire:model="text"
                rows="4"
                placeholder="Tuliskan pengalaman Anda di sini..."
                class="w-full px-8 py-6 bg-slate-50 dark:bg-white/[0.02] border border-slate-100 dark:border-white/5 rounded-[30px] text-slate-900 dark:text-white font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none resize-none @error('text') border-red-500 @enderror"></textarea>
            @error('text') <span class="text-red-500 text-xs font-bold ml-2">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-4">
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Pekerjaan / Role (Opsional)</label>
            <input 
                type="text"
                wire:model="role"
                placeholder="E.g. Fullstack Developer, Mahasiswa"
                class="w-full px-8 py-6 bg-slate-50 dark:bg-white/[0.02] border border-slate-100 dark:border-white/5 rounded-[30px] text-slate-900 dark:text-white font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none @error('role') border-red-500 @enderror">
            @error('role') <span class="text-red-500 text-xs font-bold ml-2">{{ $message }}</span> @enderror
        </div>

        <button type="submit" 
            class="w-full md:w-auto px-12 py-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[30px] font-black tracking-tighter text-lg shadow-xl shadow-indigo-600/20 active:scale-95 transition-all flex items-center justify-center space-x-3">
            <span>Simpan Testimoni</span>
            <i class="fa-solid fa-paper-plane text-sm"></i>
        </button>
    </form>
</div>
