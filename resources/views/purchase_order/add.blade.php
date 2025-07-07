@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
    <div id="app" class="max-w-7xl mx-auto px-4 py-8" data-subkriteria-url="{{ route('purchase.index') }}">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => route('purchase.index')],
                ['label' => 'Purchase Order', 'url' => route('purchase.index')],
                ['label' => 'Add Purchase Order', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Purchase Order</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Form -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('purchase.submit') }}" method="POST" class="space-y-6" data-store-form>
                @csrf
                <!-- Nama Vendor -->
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
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
                    <div class="w-full">
                        <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                        <input type="text" name="noPO" id="noPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nomor Purchase Order" required>
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal PO -->
                    <div class="w-full">
                        <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                        <input type="date" name="tanggalPO" id="tanggalPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <!-- No Kontrak -->
                    <div class="w-full">
                        <label for="noKontrak" class="block mb-1 font-medium text-gray-700">No Kontrak <span
                                class="opacity-50">(Optional)</span></label>
                        <input type="text" name="noKontrak" id="noKontrak"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nomor Kontrak">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal Revisi -->
                    <div class="w-full">
                        <label for="tanggalRevisi" class="block mb-1 font-medium text-gray-700">Tanggal Revisi
                            <span class="opacity-50">(Optional)</span></label>
                        <input type="date" name="tanggalRevisi" id="tanggalRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Incoterm -->
                    <div class="w-full">
                        <label for="incoterm" class="block mb-1 font-medium text-gray-700">Incoterm <span
                                class="opacity-50">(Optional)</span></label>
                        <input type="text" name="incoterm" id="incoterm"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Incoterm">
                    </div>
                </div>

                <!-- Purchase Order Items -->
                @include('components.purchase-order-items')

                <!-- RFQ Details Accordion -->
                @include('components.rfq-form')

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
        window.vendors = @json($vendors);
        window.materials = @json($materials);
    </script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
