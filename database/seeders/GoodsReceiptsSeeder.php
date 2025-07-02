<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsReceiptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goods_receipts')->insert([
            [
                'no_dokumen' => 'DOC001',
                'tanggal_dok' => '2025-06-01',
                'tanggal_terima' => '2025-06-02',
                'purchaseOrderId' => 1,
                'no_surat_jalan' => 'SJ001',
                'proyek' => 'Project A',
                'halaman' => 'Page 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_dokumen' => 'DOC002',
                'tanggal_dok' => '2025-06-03',
                'tanggal_terima' => '2025-06-04',
                'purchaseOrderId' => 2,
                'no_surat_jalan' => 'SJ002',
                'proyek' => null,
                'halaman' => 'Page 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}