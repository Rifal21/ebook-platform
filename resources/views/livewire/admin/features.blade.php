<?php

use Livewire\Volt\Component;
use App\Models\Feature;

new class extends Component {
    public $features;
    public $title = '';
    public $description = '';
    public $icon = '';
    public $editId = null;

    public function mount()
    {
        $this->features = Feature::all();
    }

    public function with()
    {
        return [
            'availableIcons' => [
                'M13 10V3L4 14h7v7l9-11h-7z' => 'Petir',
                'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' => 'Sukses',
                'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' => 'Buku',
                'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z' => 'Bintang Berkilau',
                'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' => 'Bintang',
                'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z' => 'Gembok Keamanan',
                'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z' => 'Hati',
                'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' => 'Tas Kerja',
                'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z' => 'Smartphone',
                'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z' => 'Awan',
            ]
        ];
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        if ($this->editId) {
            Feature::find($this->editId)->update([
                'title' => $this->title,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
        } else {
            Feature::create([
                'title' => $this->title,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
        }

        $this->reset(['title', 'description', 'icon', 'editId']);
        $this->features = Feature::all();
        session()->flash('message', 'Data fitur berhasil disimpan!');
    }

    public function edit($id)
    {
        $feature = Feature::find($id);
        $this->editId = $feature->id;
        $this->title = $feature->title;
        $this->description = $feature->description;
        $this->icon = $feature->icon;
    }

    public function delete($id)
    {
        Feature::find($id)->delete();
        $this->features = Feature::all();
    }

    public function cancel()
    {
        $this->reset(['title', 'description', 'icon', 'editId']);
    }
}; ?>

<div class="max-w-7xl mx-auto py-10">
    @section('title', 'Kelola Keunggulan/Fitur')

    <div
        class="mb-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">
                {{ $editId ? 'Edit Fitur' : 'Tambah Fitur Baru' }}</h3>
        </div>
        <div class="p-8">
            @if (session()->has('message'))
                <div
                    class="bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 p-4 rounded-xl font-bold text-sm mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6">
                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Judul</label>
                    <input wire:model="title" type="text"
                        class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                    @error('title')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Deskripsi</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4 ml-2">Pilih Ikon Cepat</label>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($availableIcons as $path => $name)
                            <button type="button" wire:click="$set('icon', '{{ $path }}')" 
                                class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center space-y-3 transition-all 
                                {{ $icon === $path ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-950/50 text-slate-400 hover:border-indigo-200 dark:hover:border-indigo-800' }}">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"></path>
                                </svg>
                                <span class="text-[10px] font-bold text-center leading-tight">{{ $name }}</span>
                            </button>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Atau Paste SVG Custom (d-path)</label>
                        <input wire:model="icon" type="text" placeholder="M12 8c..."
                            class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-mono text-xs">
                        @error('icon')
                            <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-black shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition">Simpan</button>
                    @if ($editId)
                        <button type="button" wire:click="cancel"
                            class="bg-slate-200 dark:bg-white/10 text-slate-600 dark:text-white px-8 py-4 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-white/20 transition">Batalkan</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">Daftar Fitur Saat Ini</h3>
        </div>
        <div class="p-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-white/10 border-t-0 p-4">
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Judul</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Deskripsi</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse ($features as $f)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">{{ $f->title }}</td>
                            <td class="py-4 px-6 text-slate-500 text-sm max-w-sm truncate">{{ $f->description }}</td>
                            <td class="py-4 px-6 text-right space-x-3">
                                <button wire:click="edit({{ $f->id }})"
                                    class="text-indigo-600 hover:text-indigo-800 font-bold text-sm">Edit</button>
                                <button wire:click="delete({{ $f->id }})"
                                    wire:confirm="Sadar untuk menghapus fitur ini?"
                                    class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-400 font-bold">Belum ada fitur
                                tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
