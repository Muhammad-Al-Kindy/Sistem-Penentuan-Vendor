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
        $vendor1 = Vendor::where('namaVendor', 'Vendor A')->first();
        $vendor2 = Vendor::where('namaVendor', 'Vendor B')->first();

        $contacts = [];

        if ($vendor1) {
            $contacts[] = [
                'vendorId' => $vendor1->idVendor,
                'contactPerson' => 'John Doe',
                'telepon' => '08123456789',
                'fax' => '021123456',
                'email' => 'john.doe@example.com',
                'jabatan' => 'Manager',
            ];
        }

        if ($vendor2) {
            $contacts[] = [
                'vendorId' => $vendor2->idVendor,
                'contactPerson' => 'Jane Smith',
                'telepon' => '08987654321',
                'fax' => '021654321',
                'email' => 'jane.smith@example.com',
                'jabatan' => null,
            ];
        }

        if (!empty($contacts)) {
            DB::table('vendor_contacts')->insert($contacts);
        }
    }
}