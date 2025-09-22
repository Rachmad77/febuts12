<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeederBlogCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Berita',
                'slug' => 'berita',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
            ],
            [
                'name' => 'Artikel',
                'slug' => 'artikel',
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
            ],
        ];

        foreach ($data as $item) {
            BlogCategory::create($item);
        }
    }
}
