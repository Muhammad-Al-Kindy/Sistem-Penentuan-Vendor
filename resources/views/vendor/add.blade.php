@extends('layouts.app')

@section('title', 'Create Vendor')

@section('content')
    <div id="app" data-subkriteria-url="{{ route('vendor.index') }}" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Vendor dan Kontak</h1>

            <!-- Form -->
            <form action="{{ route('vendor.submit') }}" method="POST" class="space-y-6" data-store-form>
                @csrf

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Vendor Info -->
                    <div class="w-full">
                        <label for="namaVendor" class="block mb-1 font-medium text-gray-700">Nama Perusahaan</label>
                        <input type="text" name="namaVendor" id="namaVendor"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="w-full">
                        <label for="NPWP" class="block mb-1 font-medium text-gray-700">NPWP Perusahaan</label>
                        <input type="text" name="NPWP" id="NPWP"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="SPPKP" class="block mb-1 font-medium text-gray-700">SPPKP Perusahaan</label>
                        <input type="text" name="SPPKP" id="SPPKP"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="nomorIndukPerusahaan" class="block mb-1 font-medium text-gray-700">Nomor Induk Berusaha
                            Perusahaan</label>
                        <input type="text" name="nomorIndukPerusahaan" id="nomorIndukPerusahaan"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jenisPerusahaan" class="block mb-1 font-medium text-gray-700">Jenis Perusahaan</label>
                        <input type="text" name="jenisPerusahaan" id="jenisPerusahaan"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="alamatVendor" class="block mb-1 font-medium text-gray-700">Alamat Perusahaan</label>
                        <input type="text" name="alamatVendor" id="alamatVendor"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <hr class="my-6">

                <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Kontak Vendor</h2>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="contactPerson" class="block mb-1 font-medium text-gray-700">Contact Person</label>
                        <input type="text" name="contactPerson" id="contactPerson"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="telepon" class="block mb-1 font-medium text-gray-700">Telepon</label>
                        <input type="text" name="telepon" id="telepon"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="fax" class="block mb-1 font-medium text-gray-700">Fax</label>
                        <input type="text" name="fax" id="fax"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jabatan" class="block mb-1 font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4 flex justify-start gap-3">
                    <a href="{{ route('vendor.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow text-sm">
                        <i class="ri-arrow-left-line mr-1"></i> Back
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow text-sm inline-flex items-center">
                        <i class="ri-save-line mr-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
