@extends('layouts.app')

@section('title', 'Rekomendasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Rekomendasi</span>
    </nav>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Rekomendasi Vendor</h1>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                </tr>
                
                <!-- Tambahkan baris lain jika diperlukan -->
            </tbody>
        </table>
        
    </div>
    <!-- Pagination -->
<div class="mt-6 flex justify-end">
    <nav class="inline-flex items-center space-x-1 text-sm">
        <a href="#" class="px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-l">«</a>
        <a href="#" class="px-3 py-1 bg-blue-500 text-white font-semibold">1</a>
        <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 hover:bg-gray-300">2</a>
        <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-r">»</a>
    </nav>
</div>

</div>
@endsection
