@extends('layouts.app')

@section('title', 'Sub Kriteria')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => ''],
                ['label' => 'Kriteria', 'url' => route('kriteria.index')],
                ['label' => 'Sub Kriteria', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Sub Kriteria</h1>
            <a href="{{ route('subkriteria.create', ['kriteriaId' => request()->query('kriteriaId') ?? 1]) }}"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                <i class="ri-add-line mr-1"></i> Tambah Sub Kriteria
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Sub Kriteria</th>
                        <th class="px-6 py-3 text-left">Skor</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subkriterias as $index => $sub)
                        <tr class="hover:bg-blue-100 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->namaSubKriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $sub->skorSubKriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('subkriteria.edit', $sub->idSubKriteria) }}"
                                        class="text-yellow-600 hover:text-yellow-800">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    <form action="{{ route('subkriteria.destroy', $sub->idSubKriteria) }}" method="POST"
                                        data-delete-form>
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
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data sub kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $subkriterias->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
