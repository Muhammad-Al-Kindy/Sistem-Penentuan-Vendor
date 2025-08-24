<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PurchaseOrder;

class GoodsReceiptsSeeder extends Seeder
{
    public function run(): void
    {
        $receipts = [];

        $purchaseOrders = PurchaseOrder::all();

        foreach ($purchaseOrders as $po) {
            // Tentukan jumlah penerimaan untuk setiap PO (1–2 data)
            $totalReceipts = rand(1, 2);

            for ($i = 1; $i <= $totalReceipts; $i++) {
                $tanggalDok = Carbon::parse($po->tanggalPO)->addDays(rand(3, 10));
                $tanggalTerima = (clone $tanggalDok)->addDays(rand(1, 5));

                $receipts[] = [
                    'purchaseOrderId' => $po->idPurchaseOrder,
                    'vendor_id' => $po->vendorId,
                    'no_dokumen' => 'DOC' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'halaman' => 'Page ' . $i,
                    'no_surat_jalan' => 'SJ' . rand(100, 999),
                    'proyek' => 'Project ' . chr(64 + $i),
                    'tanggal_dok' => $tanggalDok->format('Y-m-d'),
                    'tanggal_terima' => $tanggalTerima->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($receipts)) {
            DB::table('goods_receipts')->insert($receipts);
        }
    }
}
