<?php

use Livewire\Volt\Component;
use App\Models\Testimonial;

new class extends Component {
    public $testimonials;
    public $name = '';
    public $role = '';
    public $text = '';
    public $editId = null;

    public function mount()
    {
        $this->testimonials = Testimonial::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'text' => 'required|string',
        ]);

        if ($this->editId) {
            Testimonial::find($this->editId)->update([
                'name' => $this->name,
                'role' => $this->role,
                'text' => $this->text,
            ]);
        } else {
            Testimonial::create([
                'name' => $this->name,
                'role' => $this->role,
                'text' => $this->text,
                'is_approved' => true, // Admin creations are approved by default
            ]);
        }

        $this->reset(['name', 'role', 'text', 'editId']);
        $this->testimonials = Testimonial::latest()->get();
        session()->flash('message', 'Data testimoni berhasil disimpan!');
    }

    public function toggleApproval($id)
    {
        $t = Testimonial::find($id);
        $t->update(['is_approved' => !$t->is_approved]);
        $this->testimonials = Testimonial::latest()->get();
    }

    public function edit($id)
    {
        $t = Testimonial::find($id);
        $this->editId = $t->id;
        $this->name = $t->name;
        $this->role = $t->role;
        $this->text = $t->text;
    }

    public function delete($id)
    {
        Testimonial::find($id)->delete();
        $this->testimonials = Testimonial::latest()->get();
    }

    public function cancel()
    {
        $this->reset(['name', 'role', 'text', 'editId']);
    }
}; ?>

<div class="max-w-7xl mx-auto py-10">
    @section('title', 'Kelola Testimoni')

    <div
        class="mb-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50">
            <h3 class="text-lg font-black text-slate-800 dark:text-white">
                {{ $editId ? 'Edit Testimoni' : 'Tambah Testimoni Baru' }}</h3>
        </div>
        <div class="p-8">
            @if (session()->has('message'))
                <div
                    class="bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 p-4 rounded-xl font-bold text-sm mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Nama
                            Tokoh/Pembeli</label>
                        <input wire:model="name" type="text"
                            class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Pekerjaan/Peran</label>
                        <input wire:model="role" type="text" placeholder="Contoh: CEO, Frontend Dev"
                            class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                        @error('role')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Isi
                        Testimoni</label>
                    <textarea wire:model="text" rows="3"
                        class="w-full bg-slate-50 dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-medium outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"></textarea>
                    @error('text')
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
            <h3 class="text-lg font-black text-slate-800 dark:text-white">Daftar Testimoni Saat Ini</h3>
        </div>
        <div class="p-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-white/10 border-t-0 p-4">
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Nama</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Pekerjaan</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Testimoni</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400">Status</th>
                        <th class="py-4 px-6 text-xs font-black uppercase text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse ($testimonials as $t)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $t->name }}</span>
                                    @if ($t->user_id)
                                        <span class="text-[9px] font-black uppercase text-indigo-500 flex items-center mt-1">
                                            <i class="fa-solid fa-user-check mr-1"></i> User Terdaftar
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-500 dark:text-slate-400 text-sm">
                                {{ $t->role }}</td>
                            <td class="py-4 px-6 text-slate-500 text-sm max-w-sm">
                                <p class="line-clamp-2">{{ $t->text }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @if (!$t->is_approved)
                                    <button wire:click="toggleApproval({{ $t->id }})" 
                                        class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[2px] hover:bg-indigo-700 transition-all flex items-center space-x-2">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Setujui</span>
                                    </button>
                                @else
                                    <div class="px-5 py-2.5 rounded-xl bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase tracking-[2px] w-fit flex items-center space-x-2">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Terbit</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-3 w-32">
                                <button wire:click="edit({{ $t->id }})"
                                    class="text-indigo-600 hover:text-indigo-800 font-bold text-sm">Edit</button>
                                <button wire:click="delete({{ $t->id }})"
                                    wire:confirm="Sadar untuk menghapus data ini?"
                                    class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 font-bold">Belum ada testimoni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
