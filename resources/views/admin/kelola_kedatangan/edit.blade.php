@extends('layouts.app')

@section('title', 'Edit Kedatangan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => ''],
                ['label' => 'Kelola Kedatangan', 'url' => route('kedatangan.index')],
                ['label' => 'Edit Kelola Kedatangan', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Kedatangan</h1>

        <form action="{{ route('kedatangan.update', $goods_receipt->idGoodsReceipt) }}" method="POST" data-update-form>
            @csrf
            @method('PUT')

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="no_dokumen">No Dokumen</label>
                    <input type="text" name="no_dokumen" id="no_dokumen"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('no_dokumen', $goods_receipt->no_dokumen) }}" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="tanggal_dok">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dok" id="tanggal_dok"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('tanggal_dok', $goods_receipt->tanggal_dok) }}" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="tanggal_terima">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" id="tanggal_terima"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('tanggal_terima', $goods_receipt->tanggal_terima) }}" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="purchaseOrderId">Purchase Order</label>
                    <select name="purchase_order_id" id="purchaseOrderId"
                        class="w-full border border-gray-300 rounded px-4 py-2" required>
                        <option value="">-- Pilih Purchase Order --</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->idPurchaseOrder }}"
                                {{ old('purchase_order_id', $goods_receipt->purchaseOrderId) == $order->idPurchaseOrder ? 'selected' : '' }}>
                                {{ $order->noPO }} - {{ $order->vendor->namaVendor ?? 'No Vendor' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="no_surat_jalan">No Surat Jalan</label>
                    <input type="text" name="no_surat_jalan" id="no_surat_jalan"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('no_surat_jalan', $goods_receipt->no_surat_jalan) }}">
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="proyek">Proyek</label>
                    <input type="text" name="proyek" id="proyek"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('proyek', $goods_receipt->proyek) }}">
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700" for="halaman">Halaman</label>
                    <input type="text" name="halaman" id="halaman"
                        class="w-full border border-gray-300 rounded px-4 py-2"
                        value="{{ old('halaman', $goods_receipt->halaman) }}">
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Items</h2>
                <table class="w-full border border-gray-300 rounded overflow-hidden text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="border border-gray-300 px-4 py-2">Deskripsi</th>
                            <th class="border border-gray-300 px-4 py-2">Qty PO</th>
                            <th class="border border-gray-300 px-4 py-2">Qty Diterima</th>
                            <th class="border border-gray-300 px-4 py-2">Qty Sesuai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itemsWithPOItemId as $item)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->deskripsi }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->qty_po }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" name="qty_diterima[]" min="0"
                                        class="w-full border border-gray-300 rounded px-2 py-1"
                                        value="{{ old('item_qty_diterima.' . $loop->index, $item->qty_diterima) }}"
                                        required>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="hidden" name="item_ids[]" value="{{ $item->purchaseOrderItemId ?? '' }}">
                                    <input type="number" name="qty_sesuai[]" min="0"
                                        class="w-full border border-gray-300 rounded px-2 py-1"
                                        value="{{ old('item_qty_sesuai.' . $loop->index, $item->qty_sesuai) }}" required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('kedatangan.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded shadow">
                    ← Kembali
                </a>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
            </div>


        </form>
    </div>
@endsection
</create_file>
