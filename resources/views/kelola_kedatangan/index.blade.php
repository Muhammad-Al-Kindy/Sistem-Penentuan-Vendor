@extends('layouts.app')

@section('title', 'Kelola Kedatangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Kelola Kedatangan</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Kedatangan</h1>
    </div>

    <div class="flex justify-between items-center mb-4">
        <form class="flex">
            <input type="text" placeholder="Cari kedatangan..."
                class="w-full md:w-96 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                🔍 Cari
            </button>
        </form>
        <a href="{{ route('kedatangan.add') }}"
            class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
            <i class="ri-add-line mr-1"></i> Tambah Kedatangan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                    <th class="px-6 py-3 text-left">Barang</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Kabel Listrik 20m</td>
                    <td class="px-6 py-4">2025-06-21</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('kedatangan.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Kabel Listrik 20m</td>
                    <td class="px-6 py-4">2025-06-21</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('kedatangan.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Kabel Listrik 20m</td>
                    <td class="px-6 py-4">2025-06-21</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('kedatangan.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Kabel Listrik 20m</td>
                    <td class="px-6 py-4">2025-06-21</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('kedatangan.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
