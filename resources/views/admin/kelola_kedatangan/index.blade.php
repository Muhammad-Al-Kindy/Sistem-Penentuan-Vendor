@extends('layouts.app')

@section('title', 'Kelola Kedatangan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <script src="{{ asset('js/delete.js') }}"></script>
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [['label' => 'Home', 'url' => ''], ['label' => 'Kelola Kedatangan', 'url' => '']];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Kedatangan</h1>
        </div>

        <div class="flex justify-between items-center mb-4">
            <form class="flex" method="GET" action="{{ route('kedatangan.index') }}">
                <input type="text" name="search" placeholder="Cari kedatangan..."
                    class="w-full md:w-96 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    value="{{ request('search') }}">
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
                    @forelse ($receipts as $index => $receipt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $receipts->firstItem() + $index }}</td>
                            <td class="px-6 py-4">{{ $receipt->vendor->namaVendor ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @foreach ($receipt->items as $item)
                                    {{ $item->deskripsi }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $receipt->tanggal_terima }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ url('/kelola-kedatangan/edit/' . $receipt->idGoodsReceipt) }}"
                                        class="text-yellow-600 hover:text-yellow-800">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    <form data-delete-form
                                        action="{{ route('kedatangan.destroy', $receipt->idGoodsReceipt) }}" method="POST"
                                        data-delete-form>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data kedatangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $receipts->links() }}
            </div>
        </div>
    @endsection
