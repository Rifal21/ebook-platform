<?php

use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $ebooks;
    public $categories;

    // Form fields
    public $title,
        $description,
        $price,
        $category_id,
        $is_published = true;
    public $cover, $file;

    public $editingEbookId = null;
    public $showForm = false;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->ebooks = Ebook::with('category')->latest()->get();
        $this->categories = Category::all();
    }

    public function create()
    {
        $this->reset(['title', 'description', 'price', 'category_id', 'is_published', 'cover', 'file', 'editingEbookId']);
        $this->showForm = true;
    }

    public function edit(Ebook $ebook)
    {
        $this->editingEbookId = $ebook->id;
        $this->title = $ebook->title;
        $this->description = $ebook->description;
        $this->price = $ebook->price;
        $this->category_id = $ebook->category_id;
        $this->is_published = $ebook->is_published;
        $this->showForm = true;
    }

    public function save()
    {
        $rules = [
            'title' => 'required|min:3',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ];

        if (!$this->editingEbookId) {
            $rules['cover'] = 'required|image|max:2048';
            $rules['file'] = 'required|mimes:pdf,epub|max:10240';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'is_published' => $this->is_published,
        ];

        if ($this->cover) {
            $data['cover_image'] = $this->cover->store('covers', 'public');
        }

        if ($this->file) {
            $data['file_path'] = $this->file->store('ebooks', 'public');
        }

        if ($this->editingEbookId) {
            Ebook::find($this->editingEbookId)->update($data);
        } else {
            Ebook::create($data);
        }

        $this->showForm = false;
        $this->loadData();
        $this->dispatch('ebook-saved');
    }

    public function delete(Ebook $ebook)
    {
        $ebook->delete();
        $this->loadData();
    }
}; ?>

<div>
    @if ($showForm)
        <div
            class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-10 shadow-sm border border-slate-100 dark:border-white/5 mb-12">
            <div class="flex justify-between items-center mb-10">
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">
                    {{ $editingEbookId ? 'Edit E-Book' : 'Tambah E-Book Baru' }}</h4>
                <button wire:click="$set('showForm', false)" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Judul
                            E-Book</label>
                        <input wire:model="title" type="text"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('title')
                            <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Kategori</label>
                        <select wire:model="category_id"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500 appearance-none">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Harga
                            (Rp)</label>
                        <input wire:model="price" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('price')
                            <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Deskripsi</label>
                        <textarea wire:model="description" rows="5"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-bold outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">Cover
                                (Img)</label>
                            <input type="file" wire:model="cover"
                                class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('cover')
                                <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3 ml-2">File
                                (PDF/Epub)</label>
                            <input type="file" wire:model="file"
                                class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            @error('file')
                                <span class="text-red-500 text-xs mt-2 block ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end space-x-4 mt-8">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-10 py-4 rounded-2xl font-black text-slate-400 hover:text-slate-600 transition-all uppercase text-xs tracking-widest">Batal</button>
                    <button type="submit" class="btn-premium px-12 py-4">SIMPAN E-BOOK</button>
                </div>
            </form>
        </div>
    @endif

    <div
        class="reveal active bg-white dark:bg-slate-900 rounded-[40px] p-10 shadow-sm border border-slate-100 dark:border-white/5 overflow-hidden">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h4 class="text-2xl font-black text-slate-900 dark:text-white">Daftar E-Book</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Total {{ $ebooks->count() }} koleksi aktif.
                </p>
            </div>
            <button wire:click="create" class="btn-premium px-8 py-3 text-sm flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Tambah Baru</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="border-b border-slate-100 dark:border-white/5 uppercase text-xs font-black tracking-widest text-slate-400">
                        <th class="py-6 px-4">Info E-Book</th>
                        <th class="py-6 px-4 text-right">Harga</th>
                        <th class="py-6 px-4 text-center">Status</th>
                        <th class="py-6 px-4 text-right pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                    @foreach ($ebooks as $ebook)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                            <td class="py-8 px-4 flex items-center space-x-6">
                                <div
                                    class="w-16 h-20 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-white/10 overflow-hidden">
                                    @if ($ebook->cover_image)
                                        <img src="{{ Storage::url($ebook->cover_image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">?
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-lg text-slate-900 dark:text-white">{{ $ebook->title }}
                                    </p>
                                    <p
                                        class="text-[10px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400 mt-1">
                                        {{ $ebook->category?->name ?? 'No Category' }}</p>
                                </div>
                            </td>
                            <td class="py-8 px-4 text-right">
                                <p class="font-black text-xl text-slate-900 dark:text-white">Rp
                                    {{ number_format($ebook->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-8 px-4 text-center">
                                <span
                                    class="px-4 py-1.5 rounded-full {{ $ebook->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600' }} text-[10px] font-black uppercase tracking-widest">
                                    {{ $ebook->is_published ? 'Publik' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-8 px-4 text-right pr-8">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="edit('{{ $ebook->id }}')"
                                        class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button onclick="confirm('Hapus e-book ini?') || event.stopImmediatePropagation()"
                                        wire:click="delete('{{ $ebook->id }}')"
                                        class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
