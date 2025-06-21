@extends('layouts.app')

@section('title', 'Edit Purchase Order')

@section('content')
    <div id="app" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Order</h1>

            <!-- Form -->
            <form action="#" method="POST" class="space-y-6" data-update-form>
                {{-- @csrf --}}
                {{-- @method('PUT') --}}

                <!-- Nama Vendor -->
                <div>
                    <label for="namaVendor" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                    <input type="text" name="namaVendor" id="namaVendor"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="PT Sinar Terang">
                </div>

                <!-- Nama Barang -->
                <div>
                    <label for="namaBarang" class="block mb-1 font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="namaBarang" id="namaBarang"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="Kabel Listrik 20m">
                </div>

                <!-- Tanggal Order -->
                <div>
                    <label for="tanggalOrder" class="block mb-1 font-medium text-gray-700">Tanggal Order</label>
                    <input type="date" name="tanggalOrder" id="tanggalOrder"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="2025-06-15">
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block mb-1 font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="5">
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
