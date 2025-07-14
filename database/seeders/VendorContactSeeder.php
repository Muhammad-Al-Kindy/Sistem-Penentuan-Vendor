<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;

class VendorContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Vendor::all();

        $contacts = [];

        foreach ($vendors as $vendor) {
            $contacts[] = [
                'vendorId' => $vendor->idVendor,
                'contactPerson' => 'Contact Person for ' . ($vendor->user->name ?? 'Unknown Vendor'),
                'telepon' => '08123456789',
                'fax' => '021123456',
                'email' => 'contact+' . $vendor->idVendor . '@example.com',
                'jabatan' => 'Manager',
            ];
        }

        if (!empty($contacts)) {
            DB::table('vendor_contacts')->insert($contacts);
        }
    }
}
