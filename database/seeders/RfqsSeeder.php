<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PurchaseOrder;

class RfqsSeeder extends Seeder
{
    public function run(): void
    {
        $rfqs = [];

        $purchaseOrders = PurchaseOrder::all();

        foreach ($purchaseOrders as $po) {
            $createdAt = Carbon::now()->subDays(rand(1, 30));

            $rfqs[] = [
                'purchaseOrderId' => $po->idPurchaseOrder,
                'no_justifikasi' => 'Justifikasi' . str_pad($po->idPurchaseOrder, 3, '0', STR_PAD_LEFT),
                'no_negosiasi' => 'Negosiasi' . str_pad($po->idPurchaseOrder, 3, '0', STR_PAD_LEFT),
                'no_rfq' => 'RFQ' . str_pad($po->idPurchaseOrder, 3, '0', STR_PAD_LEFT),
                'referensi_sph' => 'SPH' . str_pad($po->idPurchaseOrder, 3, '0', STR_PAD_LEFT),
                'rfq_collective' => 'Collective ' . chr(65 + ($po->idPurchaseOrder % 26)), // e.g. A-Z
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        DB::table('rfqs')->insert($rfqs);
    }
}
