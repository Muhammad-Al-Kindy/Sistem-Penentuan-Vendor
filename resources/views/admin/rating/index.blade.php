@extends('layouts.app')

@section('title', 'Rating')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Rating</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Rating Vendor</h1>
    </div>

    <div class="flex justify-end mb-4">
        <a href="{{ route('rating.add') }}"
            class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
            <i class="ri-add-line mr-1"></i> Tambah Rating
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                    <th class="px-6 py-3 text-left">Kualitas</th>
                    <th class="px-6 py-3 text-left">Ketepatan Waktu</th>
                    <th class="px-6 py-3 text-left">Kuantitas</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PT Sinar Terang</td>
                    <td class="px-6 py-4">Baik</td>
                    <td class="px-6 py-4">Tepat Waktu</td>
                    <td class="px-6 py-4">Sesuai</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('rating.edit') }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
