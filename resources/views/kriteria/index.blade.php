@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <div class="bg-white shadow-md rounded p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Data Kriteria</h2>
      </div>

        <div class="mb-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('kriteria.index') }}" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search kriteria..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                🔍 Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-300 shadow rounded-lg">
                <thead class="bg-blue-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 border border-gray-300">No</th>
                        <th class="px-6 py-3 border border-gray-300">Kriteria</th>
                        <th class="px-6 py-3 border border-gray-300">Bobot</th>
                        <th class="px-6 py-3 text-center border border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($kriterias as $index => $kriteria)
                    <tr class="hover:bg-blue-100 transition duration-200">
                        <td class="px-6 py-3 border border-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $kriteria->namaKriteria }}</td>
                        <td class="px-6 py-3 border border-gray-300">{{ $kriteria->bobot }}</td>
                        <td class="px-6 py-3 text-center border border-gray-300">
                            <a href="{{ route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria]) }}"
                            class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm shadow">
                                ✏️ Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $kriterias->links() }}
            </div>
        </div>


    </div>


@endsection

