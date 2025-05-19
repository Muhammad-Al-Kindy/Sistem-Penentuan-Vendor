@extends('layouts.app')

@section('title', 'Create Vendor')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Breadcrumb -->

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Vendor</h1>

        <!-- Form -->
        <form action="{{ route('vendor.submit') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Perusahaan -->
            <div>
                <label for="namaVendor" class="block mb-1 font-medium text-gray-700">Nama Perusahaan</label>
                <input type="text" name="namaVendor" id="namaVendor"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- NPWP -->
            <div>
                <label for="NPWP" class="block mb-1 font-medium text-gray-700">NPWP Perusahaan</label>
                <input type="text" name="NPWP" id="NPWP"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- SPPKP -->
            <div>
                <label for="SPPKP" class="block mb-1 font-medium text-gray-700">SPPKP Perusahaan</label>
                <input type="text" name="SPPKP" id="SPPKP"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- NIB -->
            <div>
                <label for="nomorIndukPerusahaan" class="block mb-1 font-medium text-gray-700">Nomor Induk Berusaha Perusahaan</label>
                <input type="text" name="nomorIndukPerusahaan" id="nomorIndukPerusahaan"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- jenisPerusahaan -->
            <div>
                <label for="jenisPerusahaan" class="block mb-1 font-medium text-gray-700">Jenis Perusahaan</label>
                <input type="text" name="jenisPerusahaan" id="jenisPerusahaan"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- alamatVendor -->
            <div>
                <label for="alamatVendor" class="block mb-1 font-medium text-gray-700">Alamat Perusahaan</label>
                <input type="text" name="alamatVendor" id="alamatVendor"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                    Buat Vendor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
