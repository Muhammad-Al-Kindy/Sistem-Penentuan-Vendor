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
        'bobot' => '25'
        ],
        [
        'namaKriteria' => 'Monitoring',
        'bobot' => '15'
        ],
        [
        'namaKriteria' => 'Kualitas',
        'bobot' => '30'
        ],
        [
        'namaKriteria' => 'Respon NC',
        'bobot' => '10'
        ],
        [
        'namaKriteria' => 'PO Batal',
        'bobot' => '20'
        ]
        ]);
    }
}