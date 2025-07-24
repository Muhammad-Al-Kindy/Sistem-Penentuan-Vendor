<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_kriterias')->insert([
            // 1. Delivery Time Pengiriman (kriteriaId = 1)
            ['kriteriaId' => 1, 'namaSubKriteria' => 'Tepat waktu atau lebih cepat', 'skorSubKriteria' => 3],
            ['kriteriaId' => 1, 'namaSubKriteria' => 'Terlambat 1–14 hari', 'skorSubKriteria' => 2],
            ['kriteriaId' => 1, 'namaSubKriteria' => 'Terlambat >14 hari', 'skorSubKriteria' => 1],

            // 2. Monitoring (kriteriaId = 2)
            ['kriteriaId' => 2, 'namaSubKriteria' => 'Respon Baik', 'skorSubKriteria' => 3],
            ['kriteriaId' => 2, 'namaSubKriteria' => 'Respon Cukup', 'skorSubKriteria' => 2],
            ['kriteriaId' => 2, 'namaSubKriteria' => 'Respon Buruk', 'skorSubKriteria' => 1],

            // 3. Kualitas (kriteriaId = 3)
            ['kriteriaId' => 3, 'namaSubKriteria' => 'Sangat Baik (100%)', 'skorSubKriteria' => 3],
            ['kriteriaId' => 3, 'namaSubKriteria' => 'Cukup (81%–99%)', 'skorSubKriteria' => 2],
            ['kriteriaId' => 3, 'namaSubKriteria' => 'Kurang (<80%)', 'skorSubKriteria' => 1],

            // 4. Respon NC (kriteriaId = 4)
            ['kriteriaId' => 4, 'namaSubKriteria' => 'Respon 1 hari', 'skorSubKriteria' => 3],
            ['kriteriaId' => 4, 'namaSubKriteria' => 'Respon 3 hari', 'skorSubKriteria' => 2],
            ['kriteriaId' => 4, 'namaSubKriteria' => 'Respon >5 hari', 'skorSubKriteria' => 1],

            // 5. PO Batal (kriteriaId = 5)
            ['kriteriaId' => 5, 'namaSubKriteria' => 'Karena pertimbangan REKA', 'skorSubKriteria' => 3],
            ['kriteriaId' => 5, 'namaSubKriteria' => 'Karena respon vendor buruk', 'skorSubKriteria' => 2],
            ['kriteriaId' => 5, 'namaSubKriteria' => 'Vendor gagal penuhi kewajiban', 'skorSubKriteria' => 1],
        ]);
    }
}