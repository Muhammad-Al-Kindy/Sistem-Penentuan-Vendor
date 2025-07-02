<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('purchase_orders')->insert([
            [
                'vendorId' => 1,
                'noPO' => 'PO001',
                'tanggalPO' => '2025-06-01',
                'noKontrak' => 'KON001',
                'noRevisi' => 'REV001',
                'tanggalRevisi' => '2025-06-05',
                'incoterm' => 'FOB',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendorId' => 2,
                'noPO' => 'PO002',
                'tanggalPO' => '2025-06-02',
                'noKontrak' => 'KON002',
                'noRevisi' => 'REV002',
                'tanggalRevisi' => null,
                'incoterm' => null,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}