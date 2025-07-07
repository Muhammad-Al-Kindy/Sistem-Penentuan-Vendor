<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\Material;

class MaterialVendorPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = Material::all();

        $prices = [];

        foreach ($materials as $material) {
            $vendors = Vendor::all();
            foreach ($vendors as $vendor) {
                $prices[] = [
                    'materialId' => $material->idMaterial,
                    'vendorId' => $vendor->idVendor,
                    'harga' => rand(10000, 50000), // Random price between 10k and 50k
                    'mataUang' => 'IDR',
                ];
            }
        }

        if (!empty($prices)) {
            DB::table('material_vendor_prices')->insert($prices);
        }
    }
}
