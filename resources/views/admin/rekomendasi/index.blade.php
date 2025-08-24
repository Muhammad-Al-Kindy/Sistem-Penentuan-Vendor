@extends('layouts.app')

@section('title', 'Rekomendasi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="#" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <span>Rekomendasi</span>
        </nav>

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Rekomendasi Vendor</h1>

            <!-- Filter Material -->
            <form method="POST" action="{{ route('smart.process') }}">
                @csrf
                <label for="material_id" class="mr-2 font-medium text-gray-700">Pilih Barang:</label>
                <select name="material_id" id="material_id" onchange="this.form.submit()" class="border px-3 py-1 rounded">
                    <option value="">-- Semua Barang --</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->idMaterial }}"
                            {{ isset($selectedMaterialId) && $selectedMaterialId == $material->idMaterial ? 'selected' : '' }}>
                            {{ $material->namaMaterial }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Tabel Daftar Vendor -->
        <div class="bg-white rounded-lg shadow overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- @forelse($vendors as $index => $vendor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $vendor->namaVendor }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data rekomendasi untuk barang ini.
                            </td>
                        </tr>
                    @endforelse --}}
                    @foreach ($scoredVendors as $i => $item)
                        <tr>
                            <td class="px-6 py-4">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">{{ $item['vendor']->namaVendor }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabel Hasil SMART -->
        @if (isset($result))
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Hasil Perhitungan SMART</h2>
                <table class="table-auto border w-full mb-6">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2">Alternatif</th>
                            @foreach ($result['subcriteria'] as $sub)
                                <th class="px-4 py-2">{{ $sub }}</th>
                            @endforeach
                            <th class="px-4 py-2">Skor</th>
                            <th class="px-4 py-2">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result['scores'] as $i => $score)
                            <tr>
                                <td class="border px-4 py-2">
                                    Alternatif {{ $i + 1 }} ({{ $result['vendor_names'][$i] ?? 'Unknown' }})
                                </td>
                                @foreach ($result['matrix'][$i] as $value)
                                    <td class="border px-4 py-2">{{ $value }}</td>
                                @endforeach
                                <td class="border px-4 py-2">{{ $score }}</td>
                                <td class="border px-4 py-2">{{ $result['ranking'][$i] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="text-lg font-semibold">
                    Alternatif Terbaik: {{ $result['best_alternative'] }}
                </h3>
            </div>
        @endif
    </div>
@endsection
