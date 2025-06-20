<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kriteria::insert([
            [
                'namaKriteria' => 'Delivery Time Pengiriman',
                'tipe' => 'benefit'
            ],
            [
                'namaKriteria' => 'Monitoring',
                'tipe' => 'benefit'
            ],
            [
                'namaKriteria' => 'Kualitas',
                'tipe' => 'benefit'
            ],
            [
                'namaKriteria' => 'Respon NC',
                'tipe' => 'benefit'
            ],
            [
                'namaKriteria' => 'PO Batal',
                'tipe' => 'cost'
            ]
        ]);
    }
}
