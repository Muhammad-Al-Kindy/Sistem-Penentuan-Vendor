<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GoodsReceipts;
use App\Models\PurchaseOrderItem;

class GoodsReceiptsItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [];
        $goodsReceipts = GoodsReceipts::all();

        if ($goodsReceipts->isEmpty()) {
            echo "Seeder gagal: Tidak ada data di tabel goods_receipts.\n";
            return;
        }

        foreach ($goodsReceipts as $gr) {
            // Validasi purchaseOrderId
            if (!$gr->purchaseOrderId) {
                echo "GoodsReceipt ID {$gr->idGoodsReceipt} tidak memiliki purchaseOrderId.\n";
                continue;
            }

            $poItems = PurchaseOrderItem::where('purchaseOrderId', $gr->purchaseOrderId)->get();

            if ($poItems->isEmpty()) {
                echo "PO item tidak ditemukan untuk GoodsReceipt ID {$gr->idGoodsReceipt}.\n";
                continue;
            }

            $selected = $poItems->random(min(2, $poItems->count()));

            foreach ($selected as $poItem) {
                $qty_po = $poItem->kuantitas;
                $qty_diterima = rand(1, $qty_po);
                $qty_sesuai = rand(0, $qty_diterima);

                $items[] = [
                    'goodsReceiptId' => $gr->idGoodsReceipt,
                    'materialId' => $poItem->materialId,
                    'deskripsi' => 'Item description ' . $poItem->materialId,
                    'lokasi_gudang' => 'Warehouse A',
                    'satuan' => 'pcs',
                    'ncr' => 'NCR' . rand(100, 999),
                    'qty_po' => $qty_po,
                    'qty_diterima' => $qty_diterima,
                    'qty_sesuai' => $qty_sesuai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($items)) {
            DB::table('goods_receipts_items')->insert($items);
            echo count($items) . " baris berhasil ditambahkan ke goods_receipts_items.\n";
        } else {
            echo "Tidak ada item yang disisipkan. Periksa apakah goods_receipts dan PO item tersedia.\n";
        }
    }
}