<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class extends Component {
    public $categories;
    public $name;
    public $editingCategory = null;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::latest()->get();
    }

    public function save()
    {
        $this->validate(['name' => 'required|min:3|unique:categories,name' . ($this->editingCategory ? ',' . $this->editingCategory->id : '')]);

        if ($this->editingCategory) {
            $this->editingCategory->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
        } else {
            Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
        }

        $this->reset(['name', 'editingCategory']);
        $this->loadCategories();
        $this->dispatch('category-saved');
    }

    public function edit(Category $category)
    {
        $this->editingCategory = $category;
        $this->name = $category->name;
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->loadCategories();
    }
}; ?>

<div
    class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-10 shadow-sm border border-slate-100 dark:border-white/5 relative">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h4 class="text-2xl font-black text-slate-900 dark:text-white">Kelola Kategori</h4>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Gunakan kategori untuk mengelompokkan e-book Anda.
            </p>
        </div>
    </div>

    <form wire:submit.prevent="save" class="mb-12 flex space-x-4 items-start">
        <div class="flex-1">
            <input wire:model="name" type="text" placeholder="Nama Kategori Baru..."
                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
            @error('name')
                <span class="text-red-500 text-xs mt-2 block ml-4">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-premium px-10 py-4 h-full flex items-center">
            <span>{{ $editingCategory ? 'Update' : 'Tambah' }}</span>
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($categories as $category)
            <div
                class="p-8 rounded-[35px] bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-indigo-500/20 transition-all group">
                <div class="flex justify-between items-center">
                    <div>
                        <h5 class="text-xl font-black text-slate-900 dark:text-white">{{ $category->name }}</h5>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest">
                            {{ $category->ebooks()->count() }} E-Book</p>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="edit('{{ $category->id }}')"
                            class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </button>
                        <button onclick="confirm('Hapus kategori ini?') || event.stopImmediatePropagation()"
                            wire:click="delete('{{ $category->id }}')"
                            class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
