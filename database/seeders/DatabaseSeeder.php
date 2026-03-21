<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'rifal@gmail.com'],
            [
                'name' => 'Admin Rifal',
                'role' => 'admin',
                'password' => Hash::make('falkur21'),
            ]
        );

        $category = Category::firstOrCreate(
            ['slug' => 'programming'],
            ['name' => 'Programming']
        );

        Ebook::updateOrCreate(
            ['slug' => 'mastering-laravel-13'],
            [
                'category_id' => $category->id,
                'title' => 'Mastering Laravel 13',
                'description' => 'A comprehensive guide to Laravel 13 and modern web development.',
                'price' => 49.99,
                'is_published' => true,
            ]
        );
    }
}
