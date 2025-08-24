<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $vendorIds = Vendor::pluck('idVendor')->toArray();

        if (count($vendorIds) < 1) {
            echo "No vendors to seed purchase orders.\n";
            return;
        }
        $poData = [];
        $counter = 1;
        foreach ($vendorIds as $vendorId) {
            for ($i = 0; $i < 3; $i++) {
                $poData[] = [
                    'vendorId' => $vendorId,
                    'noPO' => 'PO' . str_pad($counter, 3, '0', STR_PAD_LEFT),
                    'tanggalPO' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                    'noKontrak' => 'KON' . str_pad($counter, 3, '0', STR_PAD_LEFT),
                    'noRevisi' => 'REV' . str_pad($counter, 3, '0', STR_PAD_LEFT),
                    'tanggalRevisi' => now()->subDays(rand(5, 15))->format('Y-m-d'),
                    'incoterm' => $i % 2 === 0 ? 'FOB' : null,
                    'created_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $counter++;
            }
        }

        DB::table('purchase_orders')->insert($poData);
        echo "Inserted " . count($poData) . " purchase orders.\n";
    }
}