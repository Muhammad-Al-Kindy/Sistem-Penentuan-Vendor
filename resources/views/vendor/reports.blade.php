@extends('layouts.app')

@section('title', 'Reports Vendor')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    @php
        $breadcrumbItems = [['label' => 'Home', 'url' => ''], ['label' => 'Reports', 'url' => '']];
        $reports = [
            [
                'items' => 'Baut longgar pada mesin A',
                'tanggal_ditemukan' => '2025-07-14',
                'keterangan' => 'Perlu pengecekan ulang bagian sambungan mesin'
            ],
            [
                'items' => 'Kabel tidak sesuai standar',
                'tanggal_ditemukan' => '2025-07-13',
                'keterangan' => 'Kabel terlalu pendek dan membahayakan operator'
            ]
        ];
    @endphp
    <x-breadcrumb :items="$breadcrumbItems" />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Reports Vendor</h1>
    </div>

    <div class="flex justify-between items-center mb-4">
        <form class="flex" method="GET" action="#">
            <input type="text" name="search" placeholder="Cari laporan..."
                class="w-full md:w-96 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                🔍 Cari
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Items</th>
                    <th class="px-6 py-3 text-left">Tanggal Ditemukan</th>
                    <th class="px-6 py-3 text-left">Keterangan</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reports as $index => $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $report['items'] }}</td>
                        <td class="px-6 py-4">{{ $report['tanggal_ditemukan'] }}</td>
                        <td class="px-6 py-4">{{ $report['keterangan'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('vendor.chat', ['reportId' => $index + 1]) }}" 
                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200" 
                               title="Lihat Chat">
                                <i class="ri-message-2-line text-lg"></i>
                            </a>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
