@extends('layouts.app')

@section('title', 'Edit Purchase Order')

@section('content')
    <div id="app" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Order</h1>

            <!-- Form -->
            <form action="{{ route('purchase.update', $purchaseOrder->idPurchaseOrder) }}" method="POST" class="space-y-6"
                data-update-form>
                @csrf
                @method('PUT')

                <!-- Nama Vendor -->
                <div>
                    <label for="namaVendor" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                    <input type="text" name="namaVendor" id="namaVendor"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('namaVendor', $vendor->namaVendor) }}">
                </div>

                <!-- Purchase Order Items -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Items</label>
                    <table class="min-w-full divide-y divide-gray-200 text-sm mb-4">
                        <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama Barang</th>
                                <th class="px-6 py-3 text-left">Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($purchaseOrder->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->item->namaMaterial ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" name="items[{{ $loop->index }}][kuantitas]"
                                            value="{{ old('items.' . $loop->index . '.kuantitas', $item->kuantitas) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        <input type="hidden" name="items[{{ $loop->index }}][id]"
                                            value="{{ $item->idPurchaseOrderItem }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tanggal Order -->
                <div>
                    <label for="tanggalOrder" class="block mb-1 font-medium text-gray-700">Tanggal Order</label>
                    <input type="date" name="tanggalOrder" id="tanggalOrder"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('tanggalOrder', $purchaseOrder->tanggalPO ?? '') }}">
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
