<?php

namespace Database\Seeders;

use App\Models\PageCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeederPageCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'homepage',
                'slug' => 'homepage',
            ],
            [
                'name' => 'berita',
                'slug' => 'berita',
            ],
            [
                'name' => 'kegiatan',
                'slug' => 'kegiatan',
            ],
            [
                'name' => 'artikel',
                'slug' => 'artikel',
            ],
            [
                'name' => 'pengumuman',
                'slug' => 'pengumuman',
            ],
        ];

        foreach ($data as $item) {
            PageCategory::create($item);
        }
    }
}
