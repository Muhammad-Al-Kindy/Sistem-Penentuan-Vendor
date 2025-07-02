<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('purchase_order_items')->insert([
            [
                'purchaseOrderId' => 1,
                'materialId' => 1,
                'materialVendorPriceId' => 1,
                'kuantitas' => 100,
                'hargaPerUnit' => 5000.00,
                'mataUang' => 'IDR',
                'vat' => 10,
                'batasDiterima' => '2025-06-10',
                'total' => 550000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'purchaseOrderId' => 1,
                'materialId' => 2,
                'materialVendorPriceId' => 2,
                'kuantitas' => 50,
                'hargaPerUnit' => 15000.00,
                'mataUang' => 'IDR',
                'vat' => 10,
                'batasDiterima' => '2025-06-15',
                'total' => 825000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
