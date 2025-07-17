@extends('layouts.appvendor')

@section('title', 'Purchase Orders')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Purchase Orders</h1>

        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari purchase order..."
                class="border border-gray-300 rounded px-4 py-2 w-1/3">
            <button id="searchButton"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded ml-2">Cari</button>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full table-auto text-sm border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No PO</th>
                        <th class="px-6 py-3 text-left">Tanggal PO</th>
                        <th class="px-6 py-3 text-left">Item</th>
                        <th class="px-6 py-3 text-left">Updates</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="purchaseOrdersTableBody" class="divide-y divide-gray-200">
                    @forelse ($purchaseOrders as $order)
                        <tr>
                            <td class="px-6 py-4">{{ $order->noPO }}</td>
                            <td class="px-6 py-4">
                                {{ $order->tanggalPO ? \Carbon\Carbon::parse($order->tanggalPO)->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @foreach ($order->items as $item)
                                    {{ $item->material->namaMaterial ?? '-' }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @if ($order->vendorUpdates->isNotEmpty())
                                    @php
                                        $latestUpdate = $order->vendorUpdates->sortByDesc('tanggal_update')->first();
                                    @endphp
                                    <span class="text-green-600 font-semibold">
                                        {{ $latestUpdate->jenis_update }}
                                    </span>
                                @else
                                    <span class="text-gray-400">No updates</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('vendor.purchase_order.edit', $order->idPurchaseOrder) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No purchase orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $purchaseOrders->links() }}
            </div>
        </div>

        <script>
            document.getElementById('searchButton').addEventListener('click', function() {
                const query = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('#purchaseOrdersTableBody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        </script>
    @endsection
