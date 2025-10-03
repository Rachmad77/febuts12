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
                'code' => 'akuntansi',
                'name' => 'Program Studi Akuntansi',
                'slug' => 'Program Studi Akuntansi',
                'email' => 'akuntansi@utssurabaya.ac.id',
                'phone' => '031-5269235',
            ],
            [
                'code' => 'manajemen',
                'name' => 'Program Studi Manajemen',
                'slug' => 'Program Studi Manajemen',
                'email' => 'manajemen@utssurabaya.ac.id',
                'phone' => '031-7821358',
            ],
        ];

        foreach($data as $item){
            ProgramStudi::create($item);
        }
    }
}
