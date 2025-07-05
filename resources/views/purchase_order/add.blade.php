@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
    <div id="app" class="max-w-7xl mx-auto px-4 py-8" data-subkriteria-url="{{ route('purchase.index') }}">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Purchase Order</h1>

            <!-- Form -->
            <form action="{{ route('purchase.submit') }}" method="POST" class="space-y-6" data-store-form>
                @csrf

                <!-- Nama Vendor -->
                <div>
                    <label for="vendorId" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                    <select name="vendorId" id="vendorId" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Pilih Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->idVendor }}">{{ $vendor->namaVendor }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- No PO -->
                <div>
                    <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                    <input type="text" name="noPO" id="noPO"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nomor Purchase Order" required>
                </div>

                <!-- Tanggal PO -->
                <div>
                    <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                    <input type="date" name="tanggalPO" id="tanggalPO"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Purchase Order Items -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Purchase Order Items</h2>
                    <div>
                        <label for="materialId" class="block mb-1 font-medium text-gray-700">Material</label>
                        <select name="items[0][materialId]" id="materialId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih Material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->idMaterial }}">{{ $material->namaMaterial }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="materialVendorPriceId" class="block mb-1 font-medium text-gray-700">Material Vendor
                            Price</label>
                        <select name="items[0][materialVendorPriceId]" id="materialVendorPriceId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih Material Vendor Price</option>
                            @foreach ($materialVendorPrices as $price)
                                <option value="{{ $price->idMaterialVendorPrice }}">{{ $price->harga }}
                                    {{ $price->mataUang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kuantitas" class="block mb-1 font-medium text-gray-700">Kuantitas</label>
                        <input type="number" name="items[0][kuantitas]" id="kuantitas" min="1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Kuantitas" required>
                    </div>
                    <div>
                        <label for="hargaPerUnit" class="block mb-1 font-medium text-gray-700">Harga Per Unit</label>
                        <input type="number" name="items[0][hargaPerUnit]" id="hargaPerUnit" min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Harga Per Unit" required>
                    </div>
                    <div>
                        <label for="mataUang" class="block mb-1 font-medium text-gray-700">Mata Uang</label>
                        <input type="text" name="items[0][mataUang]" id="mataUang"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Mata Uang" required>
                    </div>
                    <div>
                        <label for="vat" class="block mb-1 font-medium text-gray-700">VAT</label>
                        <input type="number" name="items[0][vat]" id="vat" min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="VAT">
                    </div>
                    <div>
                        <label for="batasDiterima" class="block mb-1 font-medium text-gray-700">Batas Diterima</label>
                        <input type="date" name="items[0][batasDiterima]" id="batasDiterima"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Batas Diterima">
                    </div>
                    <div>
                        <label for="total" class="block mb-1 font-medium text-gray-700">Total</label>
                        <input type="number" name="items[0][total]" id="total" min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Total" required>
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                        Buat Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materialVendorPriceSelect = document.getElementById('materialVendorPriceId');
            const hargaPerUnitInput = document.getElementById('hargaPerUnit');
            const mataUangInput = document.getElementById('mataUang');

            const prices = @json($materialVendorPrices);

            materialVendorPriceSelect.addEventListener('change', function() {
                const selectedId = this.value;
                const selectedPrice = prices.find(price => price.idMaterialVendorPrice == selectedId);
                if (selectedPrice) {
                    hargaPerUnitInput.value = selectedPrice.harga;
                    mataUangInput.value = selectedPrice.mataUang;
                } else {
                    hargaPerUnitInput.value = '';
                    mataUangInput.value = '';
                }
            });
        });
    </script>
@endsection
