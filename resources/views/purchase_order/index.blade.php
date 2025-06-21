@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Purchase Order</span>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Purchase Order</h1>
    </div>

    <!-- Search & Add -->
    <div class="flex justify-between items-center mb-4">
        <form class="flex">
            <input type="text" placeholder="Cari PO..."
                class="w-full md:w-96 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                🔍 Cari
            </button>
        </form>
        <a href="{{ route('purchase_order.add') }}"
    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
    <i class="ri-add-line mr-1"></i> Tambah Order
</a>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Vendor</th>
                    <th class="px-6 py-3 text-left">Nama Barang</th>
                    <th class="px-6 py-3 text-left">Tanggal Order</th>
                    <th class="px-6 py-3 text-left">Jumlah</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Kabel Listrik 20m</td>
                    <td class="px-6 py-4">2025-06-15</td>
                    <td class="px-6 py-4">5</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                            <i class="ri-delete-bin-line text-lg"></i>
                            </a>

                        </div>
                    </td>
                    
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                    <td class="px-6 py-4">Pipa PVC 3 inch</td>
                    <td class="px-6 py-4">2025-06-16</td>
                    <td class="px-6 py-4">12</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                                </a>
    
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                    <td class="px-6 py-4">Pipa PVC 3 inch</td>
                    <td class="px-6 py-4">2025-06-16</td>
                    <td class="px-6 py-4">12</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                                </a>
    
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                    <td class="px-6 py-4">Pipa PVC 3 inch</td>
                    <td class="px-6 py-4">2025-06-16</td>
                    <td class="px-6 py-4">12</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                                </a>
    
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                    <td class="px-6 py-4">Pipa PVC 3 inch</td>
                    <td class="px-6 py-4">2025-06-16</td>
                    <td class="px-6 py-4">12</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                                </a>
    
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">CV Multi Abadi</td>
                    <td class="px-6 py-4">Pipa PVC 3 inch</td>
                    <td class="px-6 py-4">2025-06-16</td>
                    <td class="px-6 py-4">12</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus purchase order ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                                </a>
    
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Tambah baris dummy lainnya jika ingin -->
            </tbody>
        </table>
    </div>

    <!-- Dummy Pagination -->
    <div class="mt-6 flex justify-end">
        <nav class="inline-flex">
            <a href="#" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l">«</a>
            <a href="#" class="px-3 py-1 bg-blue-500 text-white">1</a>
            <a href="#" class="px-3 py-1 bg-gray-200 hover:bg-gray-300">2</a>
            <a href="#" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r">»</a>
        </nav>
    </div>
</div>
@endsection
