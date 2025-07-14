@extends('layouts.app')

@section('title', 'Edit Kedatangan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Kedatangan</h1>
        <form action="{{ route('kedatangan.update', $goods_receipt->idGoodsReceipt) }}" method="POST" class="space-y-6"
            data-update-form>
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium text-gray-700" for="no_dokumen">No Dokumen</label>
                <input type="text" name="no_dokumen" id="no_dokumen" class="w-full border border-gray-300 rounded px-4 py-2"
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
                <label class="block mb-1 font-medium text-gray-700" for="purchase_order_id">Purchase Order</label>
                <select name="purchase_order_id" id="purchase_order_id"
                    class="w-full border border-gray-300 rounded px-4 py-2" required>
                    <option value="">-- Pilih Purchase Order --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->idPurchaseOrder }}"
                            {{ old('purchase_order_id', $goods_receipt->purchaseOrderId) == $order->idPurchaseOrder ? 'selected' : '' }}>
                            {{ $order->no_po }}
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
                <input type="text" name="proyek" id="proyek" class="w-full border border-gray-300 rounded px-4 py-2"
                    value="{{ old('proyek', $goods_receipt->proyek) }}">
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700" for="halaman">Halaman</label>
                <input type="text" name="halaman" id="halaman" class="w-full border border-gray-300 rounded px-4 py-2"
                    value="{{ old('halaman', $goods_receipt->halaman) }}">
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Items</h2>
            <table class="w-full border border-gray-300 rounded">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Deskripsi</th>
                        <th class="border border-gray-300 px-4 py-2">Satuan</th>
                        <th class="border border-gray-300 px-4 py-2">Qty PO</th>
                        <th class="border border-gray-300 px-4 py-2">Qty Diterima</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemsWithPOItemId as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->deskripsi }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->satuan }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->qty_po }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="hidden" name="item_ids[]" value="{{ $item->purchaseOrderItemId ?? '' }}">
                                <input type="number" name="item_qty_diterima[]" min="0"
                                    class="w-full border border-gray-300 rounded px-2 py-1"
                                    value="{{ old('item_qty_diterima.' . $loop->index, $item->qty_diterima) }}" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
@endsection

<script src="{{ asset('js/updateKedatangan.js') }}"></script>
