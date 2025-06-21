@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
    <div id="app" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Purchase Order</h1>

            <!-- Form -->
            <form action="#" method="POST" class="space-y-6" data-store-form>
                {{-- @csrf --}}

                <!-- Nama Vendor -->
                <div>
                    <label for="namaVendor" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                    <input type="text" name="namaVendor" id="namaVendor"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: PT Sinar Terang" required>
                </div>

                <!-- Nama Barang -->
                <div>
                    <label for="namaBarang" class="block mb-1 font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="namaBarang" id="namaBarang"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Kabel Listrik 20m" required>
                </div>

                <!-- Tanggal Order -->
                <div>
                    <label for="tanggalOrder" class="block mb-1 font-medium text-gray-700">Tanggal Order</label>
                    <input type="date" name="tanggalOrder" id="tanggalOrder"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block mb-1 font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        min="1" required>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                        Buat Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
