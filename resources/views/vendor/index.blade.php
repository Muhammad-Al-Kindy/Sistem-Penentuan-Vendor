@extends('layouts.app')

@section('title', 'Vendor')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Vendor</span>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Vendor</h1>
        <a href="{{ route('vendor.create') }}"
           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
            <i class="ri-add-line mr-1"></i> Tambah Vendor
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                    <th class="px-6 py-3 text-left">NPWP Perusahaan</th>
                    <th class="px-6 py-3 text-left">Jenis Perusahaan</th>
                    <th class="px-6 py-3 text-left">Alamat Perusahaan</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($vendors as $index => $vendor)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vendors->firstItem() + $index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vendor->namaVendor }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vendor->NPWP }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vendor->jenisPerusahaan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vendor->alamatVendor }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('vendor.edit', $vendor->idVendor) }}"
                               class="text-yellow-600 hover:text-yellow-800">
                                <i class="ri-edit-box-line text-lg"></i>
                            </a>
                            <form action="{{ route('vendor.destroy', $vendor->idVendor) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus vendor ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data vendor.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $vendors->links('pagination::tailwind') }}
    </div>
</div>
@endsection
