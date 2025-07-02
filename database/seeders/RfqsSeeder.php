<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RfqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rfqs')->insert([
            [
                'purchaseOrderId' => 1,
                'no_rfq' => 'RFQ001',
                'rfq_collective' => 'Collective A',
                'referensi_sph' => 'SPH001',
                'no_justifikasi' => 'Justifikasi001',
                'no_negosiasi' => 'Negosiasi001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'purchaseOrderId' => 2,
                'no_rfq' => 'RFQ002',
                'rfq_collective' => 'Collective B',
                'referensi_sph' => 'SPH002',
                'no_justifikasi' => 'Justifikasi002',
                'no_negosiasi' => 'Negosiasi002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}