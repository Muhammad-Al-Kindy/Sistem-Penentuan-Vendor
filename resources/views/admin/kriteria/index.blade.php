@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => route('kriteria.index')],
                ['label' => 'Kriteria', 'url' => ''],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />


        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Kriteria</h1>
        </div>

        <div class="mb-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('kriteria.index') }}" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search kriteria..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                    <i class="ri-search-line mr-1"></i> Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Kriteria</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    @forelse($kriterias as $index => $kriteria)
                        <tr class="hover:bg-blue-100 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriterias->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->namaKriteria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kriteria->tipe }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria]) }}"
                                    class="text-yellow-600 hover:text-yellow-800">
                                    <i class="ri-edit-box-line text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $kriterias->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
