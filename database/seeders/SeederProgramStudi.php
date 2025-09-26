<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

Class SeederProgramStudi extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Magister Manajemen',
                'slug' => 'Magister Manajemen',
            ],
            [
                'name' => 'Program Studi Akuntansi',
                'slug' => 'Program Studi Akuntansi',
            ],
            [
                'name' => 'Program Studi Manajemen',
                'slug' => 'Program Studi Manajemen',
            ],
            [
                'name' => 'Program Studi Ilmu Ekonomi',
                'slug' => 'Program Studi Ilmu Ekonomi',
            ],
        ];

        foreach($data as $item){
            ProgramStudi::create($item);
        }
    }
}
