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
                            <tr>
                                <td class="px-4 py-2 border-b border-gray-100">Pipa Galvanis 2 Inch</td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="jumlah_diterima[]" value="20" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="qty_diterima[]" value="20" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="qty_sesuai[]" value="18" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                            </tr>
                            
                            </tr>
                            <tr>
                                <td class="px-4 py-2 border-b border-gray-100">Pipa Galvanis 2 Inch</td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="jumlah_diterima[]" value="20" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="qty_diterima[]" value="20" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-100">
                                    <input type="number" name="qty_sesuai[]" value="18" class="w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-1 focus:ring-blue-500" min="0" required>
                                </td>
                            </tr>
                            
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
            const itemsContainer = document.getElementById('items_container');
            const quantitiesContainer = document.getElementById('quantities_container');

            itemsContainer.innerHTML = '<p class="text-gray-500">Loading...</p>';
            quantitiesContainer.innerHTML = '';

            if (!purchaseOrderId) {
                itemsContainer.innerHTML =
                    '<p class="text-gray-500">Pilih perusahaan terlebih dahulu untuk memuat barang.</p>';
                return;
            }

            fetch(`/purchase-orders/${purchaseOrderId}/items`)
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error('Unexpected data format:', data);
                        itemsContainer.innerHTML = '<p class="text-red-500">Gagal memuat barang.</p>';
                        quantitiesContainer.innerHTML = '';
                        return;
                    }

                    if (data.length === 0) {
                        itemsContainer.innerHTML =
                            '<p class="text-gray-500">Tidak ada barang untuk purchase order ini.</p>';
                        return;
                    }

                    itemsContainer.innerHTML = '';
                    quantitiesContainer.innerHTML = '';

                    data.forEach((item, index) => {
                        const materialName = item.deskripsi || (item.item ? item.item.namaMaterial :
                            'Nama barang tidak tersedia');
                        const itemId = item.idPurchaseOrderItem || item.id;

                        // Create checkbox
                        const checkboxWrapper = document.createElement('div');
                        checkboxWrapper.className = 'flex items-center mb-2';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'item_ids[]';
                        checkbox.value = itemId;
                        checkbox.id = `item_checkbox_${itemId}`;
                        checkbox.className = 'mr-2';

                        // Create label
                        const label = document.createElement('label');
                        label.htmlFor = `item_checkbox_${itemId}`;
                        label.textContent = materialName;

                        checkboxWrapper.appendChild(checkbox);
                        checkboxWrapper.appendChild(label);
                        itemsContainer.appendChild(checkboxWrapper);

                        // Create quantity input
                        const quantityWrapper = document.createElement('div');
                        quantityWrapper.className = 'mb-2';

                        const quantityLabel = document.createElement('label');
                        quantityLabel.htmlFor = `item_qty_${itemId}`;
                        quantityLabel.className = 'block mb-1 font-medium text-gray-700';
                        quantityLabel.textContent = `Jumlah Diterima untuk ${materialName}`;

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'number';
                        quantityInput.name = 'item_qty_diterima[]';
                        quantityInput.id = `item_qty_${itemId}`;
                        quantityInput.className = 'w-full border border-gray-300 rounded px-4 py-2';
                        quantityInput.min = 1;
                        quantityInput.placeholder = 'Jumlah Diterima';
                        quantityInput.disabled = true;

                        quantityWrapper.appendChild(quantityLabel);
                        quantityWrapper.appendChild(quantityInput);
                        quantitiesContainer.appendChild(quantityWrapper);

                        // Enable/disable quantity input based on checkbox
                        checkbox.addEventListener('change', function() {
                            quantityInput.disabled = !this.checked;
                            if (!this.checked) {
                                quantityInput.value = '';
                            }
                        });
                    });
                })
                .catch((error) => {
                    console.error('Fetch error:', error);
                    itemsContainer.innerHTML = '<p class="text-red-500">Gagal memuat barang.</p>';
                    quantitiesContainer.innerHTML = '';
                });
        });

        // Add form submit validation to ensure at least one item is selected
        document.getElementById('goods_receipt_form').addEventListener('submit', function(event) {
            const checkedItems = document.querySelectorAll('input[name="item_ids[]"]:checked');
            if (checkedItems.length === 0) {
                event.preventDefault();
                alert('Pilih setidaknya satu barang yang diterima.');
            }
        });
    </script>
@endsection
