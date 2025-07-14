@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8" x-data="{ showModal: false, modalTop: 0, modalLeft: 0, orderId: null }">
    <!-- Breadcrumb -->
    @php
        $breadcrumbItems = [
            ['label' => 'Home', 'url' => route('vendor.purchase_order')],
            ['label' => 'Purchase Order', 'url' => ''],
        ];

        $order = [
            (object)[
                'noPO' => 'PO-001',
                'tanggalPO' => '2025-07-10',
                'vendor' => (object)[
                    'namaVendor' => 'PT Vendor A',
                    'contacts' => collect([(object)['contactPerson' => 'Andi']])
                ],
                'noKontrak' => 'KTR-001',
                'incoterm' => 'FOB',
                'idPurchaseOrder' => 1
            ],
            (object)[
                'noPO' => 'PO-002',
                'tanggalPO' => '2025-07-12',
                'vendor' => (object)[
                    'namaVendor' => 'CV Vendor B',
                    'contacts' => collect([(object)['contactPerson' => 'Budi']])
                ],
                'noKontrak' => 'KTR-002',
                'incoterm' => 'CIF',
                'idPurchaseOrder' => 2
            ]
        ];
    @endphp

    <x-breadcrumb :items="$breadcrumbItems" />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Purchase Order</h1>
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
                    <th class="px-6 py-3 text-center">Update Status</th>
                    <th class="px-6 py-3 text-center">Upload Dokumen</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($order as $index => $orderItem)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $orderItem->noPO }}</td>
                        <td class="px-6 py-4">{{ $orderItem->tanggalPO }}</td>
                        <td class="px-6 py-4">{{ $orderItem->vendor->namaVendor ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $orderItem->noKontrak ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $orderItem->incoterm ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $orderItem->vendor->contacts->first()->contactPerson ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded hover:bg-yellow-200">
                                Update
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button 
                                @click.prevent="
                                    orderId = {{ $orderItem->idPurchaseOrder }};
                                    const btn = $event.target.closest('button');
                                    const rect = btn.getBoundingClientRect();
                                    modalTop = rect.top + window.scrollY + rect.height + 8;
                                    modalLeft = rect.left + window.scrollX - 100;
                                    showModal = true;
                                "
                                class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded hover:bg-green-200">
                                Upload
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data purchase order.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Upload File -->
    <div 
        x-show="showModal" 
        x-transition 
        :style="'top: ' + modalTop + 'px; left: ' + modalLeft + 'px'" 
        class="fixed bg-white z-50 border border-gray-300 shadow-lg rounded-lg p-4 w-80"
        @click.outside="showModal = false">
        
        <h2 class="text-md font-semibold mb-2 text-gray-700">Upload Dokumen PO</h2>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" :value="orderId">

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Pilih File (PDF/DOCX)</label>
                <input type="file" name="file"
                       class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" @click="showModal = false"
                        class="px-3 py-1 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit"
                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
