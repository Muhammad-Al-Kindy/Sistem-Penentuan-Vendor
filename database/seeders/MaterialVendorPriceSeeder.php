<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Material;
use App\Models\Vendor;

class MaterialVendorPriceSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();
        $materials = Material::all();
        $data = [];

        foreach ($vendors as $vendor) {
            foreach ($materials->random(3) as $material) {
                $data[] = [
                    'vendorId' => $vendor->idVendor,
                    'materialId' => $material->idMaterial,
                    'harga' => rand(50000, 200000),
                    'mataUang' => 'IDR',

                ];
            }
        }

        DB::table('material_vendor_prices')->insert($data);
    }
}