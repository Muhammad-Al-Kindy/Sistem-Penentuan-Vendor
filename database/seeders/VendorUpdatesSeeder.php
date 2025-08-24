<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PurchaseOrder;

class VendorUpdatesSeeder extends Seeder
{
    public function run(): void
    {
        $updates = [];
        $purchaseOrders = PurchaseOrder::with('vendor')->get();

        foreach ($purchaseOrders as $po) {
            // Update jenis Progress
            $updates[] = [
                'purchase_order_id' => $po->idPurchaseOrder,
                'vendor_id' => $po->vendorId,
                'tanggal_update' => Carbon::parse($po->tanggalPO)->addDays(3),
                'jenis_update' => 'Progress',
                'keterangan' => 'Production started',
                'dokumen' => 'progress1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Update jenis Progress kedua
            $updates[] = [
                'purchase_order_id' => $po->idPurchaseOrder,
                'vendor_id' => $po->vendorId,
                'tanggal_update' => Carbon::parse($po->tanggalPO)->addDays(7),
                'jenis_update' => 'Progress',
                'keterangan' => 'Packaging complete',
                'dokumen' => 'progress2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Update jenis Dibatalkan (hanya sebagian, buat variasi)
            if ($po->idPurchaseOrder % 4 === 0) {
                $updates[] = [
                    'purchase_order_id' => $po->idPurchaseOrder,
                    'vendor_id' => $po->vendorId,
                    'tanggal_update' => Carbon::parse($po->tanggalPO)->addDays(10),
                    'jenis_update' => 'Dibatalkan',
                    'keterangan' => 'Karena pertimbangan dari REKA',
                    'dokumen' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('vendor_updates')->insert($updates);
    }
}
