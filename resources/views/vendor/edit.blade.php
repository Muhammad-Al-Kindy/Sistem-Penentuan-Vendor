@extends('layouts.app')

@section('title', 'Edit Vendor')

@section('content')
    <div id="app" data-subkriteria-url="{{ route('vendor.index') }}" class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="text-sm text-gray-500 mb-4">
            <a href="{{ route('vendor.index') }}" class="hover:underline">Home</a> >
            <span class="text-gray-800 font-semibold">Edit Vendor</span>
        </div>

        <!-- Card -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Vendor</h2>

            <form action="{{ route('vendor.update', $vendor->idVendor) }}" method="POST" class="space-y-6" data-update-form
                data-redirect-url="{{ route('vendor.index') }}">
                @csrf
                @method('PUT')

                <div>
                    <label for="namaVendor" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                    <input type="text" name="namaVendor" id="namaVendor"
                        value="{{ old('namaVendor', $vendor->namaVendor) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="NPWP" class="block text-sm font-medium text-gray-700 mb-1">NPWP Perusahaan</label>
                    <input type="text" name="NPWP" id="NPWP" value="{{ old('NPWP', $vendor->NPWP) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="SPPKP" class="block text-sm font-medium text-gray-700 mb-1">SPPKP Perusahaan</label>
                    <input type="text" name="SPPKP" id="SPPKP" value="{{ old('SPPKP', $vendor->SPPKP) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="nomorIndukPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk
                        Berusaha Perusahaan</label>
                    <input type="text" name="nomorIndukPerusahaan" id="nomorIndukPerusahaan"
                        value="{{ old('nomorIndukPerusahaan', $vendor->nomorIndukPerusahaan) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="jenisPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                        Perusahaan</label>
                    <input type="text" name="jenisPerusahaan" id="jenisPerusahaan"
                        value="{{ old('jenisPerusahaan', $vendor->jenisPerusahaan) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="alamatVendor" class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                    <input type="text" name="alamatVendor" id="alamatVendor"
                        value="{{ old('alamatVendor', $vendor->alamatVendor) }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-md font-semibold hover:bg-gray-900 transition">
                        Update Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
