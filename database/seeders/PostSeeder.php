<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Post::create([
            'title' => 'Contoh Berita Pertama',
            'slug' => 'contoh-berita-pertama',
            'excerpt' => 'Ini adalah contoh berita pertama.',
            'content' => 'Isi lengkap dari contoh berita pertama di Desa Karangrejo.',
            'featured_image' => null,
            'category_id' => 1,
            'user_id' => 1,
            'status' => 'published',
            'published_at' => now(),
            'meta' => null
        ]);
        \App\Models\Post::create([
            'title' => 'Kegiatan Gotong Royong',
            'slug' => 'kegiatan-gotong-royong',
            'excerpt' => 'Kegiatan gotong royong warga desa.',
            'content' => 'Warga Desa Karangrejo melakukan gotong royong membersihkan lingkungan.',
            'featured_image' => null,
            'category_id' => 3,
            'user_id' => 2,
            'status' => 'published',
            'published_at' => now(),
            'meta' => null
        ]);
    }
}
