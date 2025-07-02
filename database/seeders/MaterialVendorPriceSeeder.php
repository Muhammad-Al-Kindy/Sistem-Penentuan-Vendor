<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialVendorPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('material_vendor_prices')->insert([
            [
                'materialId' => 1,
                'vendorId' => 1,
                'harga' => 10000.00,
                'mataUang' => 'IDR',
            ],
            [
                'materialId' => 2,
                'vendorId' => 1,
                'harga' => 15000.00,
                'mataUang' => 'IDR',
            ],
            [
                'materialId' => 3,
                'vendorId' => 2,
                'harga' => 20000.00,
                'mataUang' => 'IDR',
            ],
        ]);
    }
}
