<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\GoodsReceiptsItem;
use App\Models\GoodsReceiptsItems;

class NonConformancesSeeder extends Seeder
{
    public function run(): void
    {
        $items = GoodsReceiptsItems::all();
        $nonConformances = [];

        foreach ($items as $item) {
            if (!$item->id) {
                continue; // skip if id is null
            }
            $foundDate = Carbon::parse($item->created_at)->addDays(rand(0, 3));
            $responseDate = $foundDate->copy()->addDays(rand(1, 3));

            $nonConformances[] = [
                'goods_receipt_item_id' => $item->id, // pastikan ini sesuai kolom PK
                'keterangan' => 'Issue with item ' . $item->materialId,
                'status' => 'closed',
                'tanggal_ditemukan' => $foundDate,
                'tanggal_respon_vendor' => $responseDate,
                'created_at' => $foundDate->copy()->subDay(),
                'updated_at' => $responseDate,
            ];
        }

        DB::table('non_conformances')->insert($nonConformances);
    }
}