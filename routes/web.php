<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('transactions', 'transactions')
    ->middleware(['auth', 'verified'])
    ->name('transactions');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/checkout/{ebook}', [\App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{ebook}', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
});


Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('admin', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('admin/ebooks', function() {
        return view('admin.ebooks');
    })->name('admin.ebooks');

    Route::get('admin/categories', function () {
        return view('admin.categories');
    })->name('admin.categories');

    Route::get('admin/transactions', function () {
        return view('admin.transactions');
    })->name('admin.transactions');
    
    Route::get('admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
    
    Route::get('admin/features', function () {
        return view('admin.features');
    })->name('admin.features');
    
    Route::get('admin/testimonials', function () {
        return view('admin.testimonials');
    })->name('admin.testimonials');
});

require __DIR__.'/auth.php';
