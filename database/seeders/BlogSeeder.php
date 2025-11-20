<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\TagCategory;
use App\Models\BlogCategory;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua tag dan kategori yang sudah ada
        $categories = BlogCategory::all();
        $tags   = TagCategory::all();

        if ($categories->count() === 0 || $tags->count() === 0){
            $this->command->warn('Kategori atau Tag belum ada di database!');
            return;
        }

        //buat contoh blog
        $blog = Blog::create([
            'title' => 'Contoh Artikel',
            'content' => 'ini cuma buat contoh aja, tujuan dari seeder ini adalah untuk menemukan error yang ada pada tambah data blog.',
            'thumbnail' => 'assets/img/uts.jpg',
            'blog_category_id' => 1, // pastikan ada kategori dengan id=1
        ]);

        // Ambil beberapa tag secara acak dan attach ke blog
        $randomTags = TagCategory::inRandomOrder()->take(2)->pluck('id');
        $blog->tags()->attach($randomTags);

        $this->command->info('seeder blog berhasil ditambahkan');
    }    
}
