@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => route('purchase.index')],
                ['label' => 'Purchase Order', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Purchase Order</h1>
        </div>
        <div class="flex items-center justify-between mb-4">
            <!-- Search Form -->
            <div class="flex flex-col">
                <form method="GET" action="{{ route('purchase.index') }}" class="mb-4 flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search vendor..."
                        class="w-full md:w-80 sm:w-52  border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400">
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="ri-search-line mr-1"></i> Cari
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('purchase.create') }}"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                    <i class="ri-add-line mr-1"></i> Tambah Order
                </a>
            </div>
        </div>


        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No PO</th>
                        <th class="px-6 py-3 text-left">Tanggal PO</th>
                        <th class="px-6 py-3 text-left">Nama Vendor</th>
                        <th class="px-6 py-3 text-left">Nomor Kontrak</th>
                        <th class="px-6 py-3 text-left">Incoterm</th>
                        <th class="px-6 py-3 text-left">Contact Person</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($order as $index => $orderItem)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->noPO }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->tanggalPO->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->vendor->namaVendor ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->noKontrak ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->incoterm ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $orderItem->vendor->contacts->first()->contactPerson ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('purchase.edit', $orderItem->idPurchaseOrder) }}"
                                        class="text-yellow-600 hover:text-yellow-800">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    {{-- Lihat Progress --}}
                                    <a href="{{ route('purchase.progress', $orderItem->idPurchaseOrder) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Lihat Progress">
                                        <i class="ri-timeline-view text-lg"></i>
                                    </a>
                                    <form action="{{ route('purchase.destroy', $orderItem->idPurchaseOrder) }}"
                                        method="POST" data-delete-form>
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
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data purchase order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-center">
            {{ $order->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
