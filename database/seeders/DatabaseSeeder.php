<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            VendorContactSeeder::class,
            MaterialSeeder::class,
            MaterialVendorPriceSeeder::class,
            PurchaseOrderSeeder::class,
            PurchaseOrderItemSeeder::class,
            GoodsReceiptsSeeder::class,
            GoodsReceiptsItemsSeeder::class,
            RfqsSeeder::class,
            KriteriaSeeder::class,
        ]);
    }
}
