<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\Material;
use App\Models\MaterialVendorPrice;

class PurchaseOrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all purchase orders
        $purchaseOrders = PurchaseOrder::all();

        if ($purchaseOrders->isEmpty()) {
            echo "No purchase orders found to seed items.\n";
            return;
        }

        // Get all materials and vendor prices
        $materials = Material::all();
        $vendorPrices = MaterialVendorPrice::all();

        if ($materials->isEmpty() || $vendorPrices->isEmpty()) {
            echo "No materials or vendor prices found to seed items.\n";
            return;
        }

        $itemsData = [];

        foreach ($purchaseOrders as $purchaseOrder) {
            // Get vendor-specific materials and prices
            $vendorSpecificPrices = $vendorPrices->where('vendorId', $purchaseOrder->vendorId);

            if ($vendorSpecificPrices->isEmpty()) {
                continue;
            }

            // Create 2-4 items per purchase order
            $itemCount = rand(2, 4);
            $selectedPrices = $vendorSpecificPrices->random(min($itemCount, $vendorSpecificPrices->count()));

            foreach ($selectedPrices as $price) {
                $quantity = rand(10, 500);
                $unitPrice = $price->harga;
                $vatRate = rand(0, 15);
                $subtotal = $quantity * $unitPrice;
                $total = $subtotal * (1 + $vatRate / 100);

                $itemsData[] = [
                    'purchaseOrderId' => $purchaseOrder->idPurchaseOrder,
                    'materialId' => $price->materialId,
                    'materialVendorPriceId' => $price->idMaterialVendorPrice,
                    'kuantitas' => $quantity,
                    'hargaPerUnit' => $unitPrice,
                    'mataUang' => $price->mataUang,
                    'vat' => $vatRate,
                    'batasDiterima' => now()->addDays(rand(7, 30))->format('Y-m-d'),
                    'total' => $total,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($itemsData)) {
            DB::table('purchase_order_items')->insert($itemsData);
            echo "Inserted " . count($itemsData) . " purchase order items.\n";
        } else {
            echo "No items could be created due to missing relationships.\n";
        }
    }
}