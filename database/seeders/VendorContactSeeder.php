<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendor_contacts')->insert([
            [
                'vendorId' => 1,
                'contactPerson' => 'John Doe',
                'telepon' => '08123456789',
                'fax' => '021123456',
                'email' => 'john.doe@example.com',
                'jabatan' => 'Manager',
            ],
            [
                'vendorId' => 2,
                'contactPerson' => 'Jane Smith',
                'telepon' => '08987654321',
                'fax' => '021654321',
                'email' => 'jane.smith@example.com',
                'jabatan' => null,
            ],
        ]);
    }
}