<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsReceiptsItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goods_receipts_items')->insert([
            [
                'goodsReceiptId' => 1,
                'materialId' => 1,
                'deskripsi' => 'Item description 1',
                'satuan' => 'pcs',
                'qty_po' => 100,
                'qty_diterima' => 90,
                'qty_sesuai' => 90,
                'ncr' => null,
                'lokasi_gudang' => 'Warehouse A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'goodsReceiptId' => 1,
                'materialId' => 2,
                'deskripsi' => 'Item description 2',
                'satuan' => 'kg',
                'qty_po' => 50,
                'qty_diterima' => 50,
                'qty_sesuai' => 50,
                'ncr' => 'NCR001',
                'lokasi_gudang' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
