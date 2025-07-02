<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'kodeMaterial' => 'MAT001',
                'namaMaterial' => 'Material A',
                'deskripsiMaterial' => 'Description for Material A',
                'satuanMaterial' => 'pcs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeMaterial' => 'MAT002',
                'namaMaterial' => 'Material B',
                'deskripsiMaterial' => 'Description for Material B',
                'satuanMaterial' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeMaterial' => 'MAT003',
                'namaMaterial' => 'Material C',
                'deskripsiMaterial' => null,
                'satuanMaterial' => 'ltr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}