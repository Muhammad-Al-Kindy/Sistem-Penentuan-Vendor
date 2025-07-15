@extends('layouts.app')

@section('title', 'Tambah Kedatangan')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Form Tambah Kedatangan</h1>

        <form id="goods_receipt_form" action="{{ route('goods-receipts.store') }}" method="POST"
            class="space-y-6 bg-white p-8 shadow rounded-lg">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">No Dokumen</label>
                    <input type="text" name="no_dokumen"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dok" class="w-full border border-gray-300 rounded px-4 py-2"
                        required>
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" class="w-full border border-gray-300 rounded px-4 py-2"
                        required>
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Nama Perusahaan</label>
                    <select id="purchase_order_select" name="purchase_order_id"
                        class="w-full border border-gray-300 rounded px-4 py-2" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->idPurchaseOrder }}">
                                {{ $order->vendor->namaVendor ?? 'Unknown Vendor' }} - PO: {{ $order->noPO }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">No Surat Jalan</label>
                    <input type="text" name="no_surat_jalan" class="w-full border border-gray-300 rounded px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1 text-gray-700">Proyek</label>
                    <input type="text" name="proyek" class="w-full border border-gray-300 rounded px-4 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1 text-gray-700">Halaman</label>
                    <input type="text" name="halaman" class="w-full border border-gray-300 rounded px-4 py-2">
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-sm border border-gray-200 shadow-sm rounded-lg overflow-hidden">

                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border px-4 py-2">Nama Barang</th>
                                <th class="border px-4 py-2">Jumlah Diterima</th>
                                <th class="border px-4 py-2">Qty Diterima</th>
                                <th class="border px-4 py-2">Qty Sesuai</th>
                            </tr>
                        </thead>
                        <tbody id="items_table_body">
                            {{-- Items will be dynamically loaded here --}}
                        </tbody>

                    </table>
                </div>
            </div>



            <div class="flex justify-end gap-4">
                <a href="{{ route('goods-receipts.index') }}"
                    class="inline-flex items-center px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 shadow">
                    ← Kembali
                </a>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- Javascript for dynamic loading of items based on selected purchase order --}}
    <script>
        document.getElementById('purchase_order_select').addEventListener('change', function() {
            const purchaseOrderId = this.value;
            const itemsTableBody = document.getElementById('items_table_body');

            itemsTableBody.innerHTML =
                '<tr><td colspan="5" class="text-center text-gray-500 py-4">Loading...</td></tr>';

            if (!purchaseOrderId) {
                itemsTableBody.innerHTML =
                    '<tr><td colspan="5" class="text-center text-gray-500 py-4">Pilih perusahaan terlebih dahulu untuk memuat barang.</td></tr>';
                return;
            }

            fetch(`/purchase-orders/${purchaseOrderId}/items`)
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error('Unexpected data format:', data);
                        itemsTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center text-red-500 py-4">Gagal memuat barang.</td></tr>';
                        return;
                    }

                    if (data.length === 0) {
                        itemsTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center text-gray-500 py-4">Tidak ada barang untuk purchase order ini.</td></tr>';
                        return;
                    }

                    itemsTableBody.innerHTML = '';

                    data.forEach((item, index) => {
                        const materialName = item.deskripsi || (item.item ? item.item.namaMaterial :
                            'Nama barang tidak tersedia');
                        const itemId = item.idPurchaseOrderItem || item.id;

                        const row = document.createElement('tr');

                        // Nama Barang
                        const nameCell = document.createElement('td');
                        nameCell.className = 'border px-4 py-2';
                        nameCell.textContent = materialName;
                        row.appendChild(nameCell);

                        // Hidden input for item_ids
                        const hiddenItemIdInput = document.createElement('input');
                        hiddenItemIdInput.type = 'hidden';
                        hiddenItemIdInput.name = 'item_ids[]';
                        hiddenItemIdInput.value = itemId;
                        row.appendChild(hiddenItemIdInput);

                        // Jumlah Diterima input
                        const jumlahDiterimaCell = document.createElement('td');
                        jumlahDiterimaCell.className = 'border px-4 py-2';
                        const jumlahInput = document.createElement('input');
                        jumlahInput.type = 'number';
                        jumlahInput.name = 'item_qty_diterima[]';
                        jumlahInput.min = 0;
                        jumlahInput.required = true;
                        jumlahInput.className =
                            'w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500';
                        jumlahDiterimaCell.appendChild(jumlahInput);
                        row.appendChild(jumlahDiterimaCell);

                        // Qty Diterima input
                        const qtyDiterimaCell = document.createElement('td');
                        qtyDiterimaCell.className = 'border px-4 py-2';
                        const qtyDiterimaInput = document.createElement('input');
                        qtyDiterimaInput.type = 'number';
                        qtyDiterimaInput.name = 'qty_diterima[]';
                        qtyDiterimaInput.min = 0;
                        qtyDiterimaInput.required = true;
                        qtyDiterimaInput.className =
                            'w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500';
                        qtyDiterimaCell.appendChild(qtyDiterimaInput);
                        row.appendChild(qtyDiterimaCell);

                        // Qty Sesuai input
                        const qtySesuaiCell = document.createElement('td');
                        qtySesuaiCell.className = 'border px-4 py-2';
                        const qtySesuaiInput = document.createElement('input');
                        qtySesuaiInput.type = 'number';
                        qtySesuaiInput.name = 'qty_sesuai[]';
                        qtySesuaiInput.min = 0;
                        qtySesuaiInput.required = true;
                        qtySesuaiInput.className =
                            'w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500';
                        qtySesuaiCell.appendChild(qtySesuaiInput);
                        row.appendChild(qtySesuaiCell);

                        itemsTableBody.appendChild(row);
                    });
                })
                .catch((error) => {
                    console.error('Fetch error:', error);
                    itemsTableBody.innerHTML =
                        '<tr><td colspan="5" class="text-center text-red-500 py-4">Gagal memuat barang.</td></tr>';
                });
        });

        // Add form submit validation to ensure at least one item is present
        document.getElementById('goods_receipt_form').addEventListener('submit', function(event) {
            const itemsTableBody = document.getElementById('items_table_body');
            if (itemsTableBody.children.length === 0) {
                event.preventDefault();
                alert('Pilih setidaknya satu barang yang diterima.');
            }
        });
    </script>
@endsection
