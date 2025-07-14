@extends('layouts.app')

@section('title', 'Edit Vendor')

@section('content')
    <div id="app" data-subkriteria-url="{{ route('vendor.index') }}" class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => ''],
                ['label' => 'Vendor', 'url' => route('vendor.index')],
                ['label' => 'Edit Vendor', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <!-- Card -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Vendor</h2>

            <form action="{{ route('vendor.update', $vendor) }}" method="POST" class="space-y-6" data-update-vendor-form
                data-redirect-url="{{ route('vendor.index') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $vendor->idVendor }}">

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">

                        <label for="namaVendor" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" name="namaVendor" id="namaVendor"
                            value="{{ old('namaVendor', $vendor->namaVendor) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="w-full">
                        <label for="NPWP" class="block text-sm font-medium text-gray-700 mb-1">NPWP Perusahaan</label>
                        <input type="text" name="NPWP" id="NPWP" value="{{ old('NPWP', $vendor->NPWP) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="SPPKP" class="block text-sm font-medium text-gray-700 mb-1">SPPKP Perusahaan</label>
                        <input type="text" name="SPPKP" id="SPPKP" value="{{ old('SPPKP', $vendor->SPPKP) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="nomorIndukPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk
                            Berusaha Perusahaan</label>
                        <input type="text" name="nomorIndukPerusahaan" id="nomorIndukPerusahaan"
                            value="{{ old('nomorIndukPerusahaan', $vendor->nomorIndukPerusahaan) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jenisPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                            Perusahaan</label>
                        <input type="text" name="jenisPerusahaan" id="jenisPerusahaan"
                            value="{{ old('jenisPerusahaan', $vendor->jenisPerusahaan) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="alamatVendor" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                            Perusahaan</label>
                        <input type="text" name="alamatVendor" id="alamatVendor"
                            value="{{ old('alamatVendor', $vendor->alamatVendor) }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Contact Information Section -->
                @php
                    $contact = $vendor->contacts->first();
                @endphp
                <hr class="my-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Kontak Vendor</h2>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="contactPerson" class="block mb-1 font-medium text-gray-700">Contact Person</label>
                        <input type="text" name="contactPerson" id="contactPerson"
                            value="{{ old('contactPerson', $contact->contactPerson ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="telepon" class="block mb-1 font-medium text-gray-700">Telepon</label>
                        <input type="text" name="telepon" id="telepon"
                            value="{{ old('telepon', $contact->telepon ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="fax" class="block mb-1 font-medium text-gray-700">Fax</label>
                        <input type="text" name="fax" id="fax" value="{{ old('fax', $contact->fax ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $contact->email ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jabatan" class="block mb-1 font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            value="{{ old('jabatan', $contact->jabatan ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-4">
                    <a href="{{ route('vendor.index') }}"
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 shadow">
                        ← Kembali
                    </a>
                
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-md font-semibold hover:bg-gray-900 transition">
                        Update Vendor
                    </button>
                </div>
                
            </form>
        </div>
    </div>
@endsection
