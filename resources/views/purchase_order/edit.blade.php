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

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Nama Vendor -->
                    <div class="w-full">
                        <label for="vendorId" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                        <select name="vendorId" id="vendorId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled>Pilih Vendor</option>
                            @foreach ($vendors as $v)
                                <option value="{{ $v->idVendor }}"
                                    {{ $v->idVendor == old('vendorId', $purchaseOrder->vendorId) ? 'selected' : '' }}>
                                    {{ $v->namaVendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- No PO -->
                    <div class="w-full">
                        <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                        <input type="text" name="noPO" id="noPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('noPO', $purchaseOrder->noPO) }}">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal Order -->
                    <div class="w-full">
                        <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                        <input type="date" name="tanggalPO" id="tanggalPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('tanggalPO', $purchaseOrder->tanggalPO ?? '') }}">
                    </div>
                    <div class="w-full">
                        <label for="noKontrak" class="block mb-1 font-medium text-gray-700">No Kontrak</label>
                        <input type="text" name="noKontrak" id="noKontrak"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('noKontrak', $purchaseOrder->noKontrak) }}">
                    </div>

                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="tanggalRevisi" class="block mb-1 font-medium text-gray-700">Tanggal Revisi</label>
                        <input type="date" name="tanggalRevisi" id="tanggalRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('tanggalRevisi', $purchaseOrder->tanggalRevisi) }}">
                    </div>
                    <div class="w-full">
                        <label for="noRevisi" class="block mb-1 font-medium text-gray-700">No Revisi</label>
                        <input type="text" name="noRevisi" id="noRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('noRevisi', $purchaseOrder->noRevisi) }}">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="incoterm" class="block mb-1 font-medium text-gray-700">Incoterm</label>
                        <input type="text" name="incoterm" id="incoterm"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('incoterm', $purchaseOrder->incoterm) }}">
                    </div>

                </div>





                <!-- Purchase Order Items -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Items</label>
                    <table class="min-w-full divide-y divide-gray-200 text-sm mb-4">
                        <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama Barang</th>
                                <th class="px-6 py-3 text-left">Kuantitas</th>
                                <th class="px-6 py-3 text-left">Harga Per Unit</th>
                                <th class="px-6 py-3 text-left">Mata Uang</th>
                                <th class="px-6 py-3 text-left">VAT</th>
                                <th class="px-6 py-3 text-left">Batas Diterima</th>
                                <th class="px-6 py-3 text-left">Total</th>
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01"
                                            name="items[{{ $loop->index }}][hargaPerUnit]"
                                            value="{{ old('items.' . $loop->index . '.hargaPerUnit', $item->hargaPerUnit) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="items[{{ $loop->index }}][mataUang]"
                                            value="{{ old('items.' . $loop->index . '.mataUang', $item->mataUang) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" name="items[{{ $loop->index }}][vat]"
                                            value="{{ old('items.' . $loop->index . '.vat', $item->vat) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="date" name="items[{{ $loop->index }}][batasDiterima]"
                                            value="{{ old('items.' . $loop->index . '.batasDiterima', $item->batasDiterima) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" name="items[{{ $loop->index }}][total]"
                                            value="{{ old('items.' . $loop->index . '.total', $item->total) }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        <input type="hidden" name="items[{{ $loop->index }}][id]"
                                            value="{{ $item->idPurchaseOrderItem }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>

                <!-- RFQ Details Accordion -->
                @include('components.rfq-form')
            </form>
        </div>
    </div>
@endsection
