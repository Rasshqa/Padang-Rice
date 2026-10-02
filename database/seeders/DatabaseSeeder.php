<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@padangrice.com',
            'password' => Hash::make('password'),
        ]);

        // News
        News::create([
            'title' => 'APA SAJA MAKANAN KHAS NUSANTARA?',
            'slug' => 'apa-saja-makanan-khas-nusantara',
            'image' => 'assets/ASET/nasipadang-hero.jpg',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare, augue eu rutrum commodo, dui diam convallis arcu, eget consectetur ex sem eget lacus. Nullam vitae dignissim neque, vel luctus ex. Fusce sit amet viverra ante.',
            'author' => 'Admin',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $newsImages = [
            'assets/ASET/nasipadang-1.jpg',
            'assets/ASET/nasipadang-2.jpg',
            'assets/ASET/nasipadang-3.jpg',
            'assets/ASET/nasipadang-4.jpg',
            'assets/ASET/nasipadang-5.jpg',
            'assets/ASET/nasipadang-6.jpg',
        ];

        foreach ($newsImages as $index => $image) {
            News::create([
                'title' => 'LOREM IPSUM',
                'slug' => 'lorem-ipsum-' . ($index + 2),
                'image' => $image,
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare, augue eu rutrum commodo.',
                'author' => 'Admin',
                'status' => 'published',
                'published_at' => now()->subDays($index),
            ]);
        }

        // Gallery
        $galleryImages = [
            'assets/ASET/nasipadang-1.jpg',
            'assets/ASET/nasipadang-2.jpg',
            'assets/ASET/nasipadang-3.jpg',
            'assets/ASET/nasipadang-4.jpg',
            'assets/ASET/nasipadang-5.jpg',
            'assets/ASET/nasipadang-6.jpg',
            'assets/ASET/nasipadang-7.jpg',
            'assets/ASET/nasipadang-8.jpg',
            'assets/ASET/nasipadang-9.jpg',
            'assets/ASET/nasipadang-10.jpg',
            'assets/ASET/nasipadang-11.jpg',
            'assets/ASET/nasipadang-12.jpg',
        ];

        foreach ($galleryImages as $index => $image) {
            Gallery::create([
                'title' => 'Gallery ' . ($index + 1),
                'image' => $image,
                'description' => 'Beautiful food photography',
                'category' => 'food',
                'status' => 'active',
                'sort_order' => $index,
            ]);
        }

        // Settings
        Setting::create(['setting_key' => 'site_name', 'setting_value' => 'PADANG RICE']);
        Setting::create(['setting_key' => 'site_description', 'setting_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.']);
        Setting::create(['setting_key' => 'email', 'setting_value' => 'padangrice@gmail.com']);
        Setting::create(['setting_key' => 'phone', 'setting_value' => '+62 812 3456 7890']);
        Setting::create(['setting_key' => 'location', 'setting_value' => 'Kota Bandung, Jawa Barat']);
    }
}
