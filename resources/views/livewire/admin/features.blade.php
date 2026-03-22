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
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Ikon (SVG
                        Path - Opsional)</label>
                    <input wire:model="icon" type="text" placeholder="M12 8c..."
                        class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-mono text-xs">
                    <p class="text-xs text-slate-500 mt-2 px-2">Cari icon svg di heroicons.com dan paste value bagian
                        dalamnya (d atribut).</p>
                    @error('icon')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
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
