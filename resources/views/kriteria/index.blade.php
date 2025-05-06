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
        <table class="min-w-full bg-yellow-800 text-white rounded shadow text-right">
          <thead>
            <tr class="bg-yellow-900 text-white">
              <th class="px-4 py-2 text-right">No</th>
              <th class="px-4 py-2 text-right">Kriteria</th>
              <th class="px-4 py-2 text-right">Bobot</th>
              <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($kriterias as $index => $kriteria)
            <tr class="odd:bg-yellow-700 even:bg-yellow-600">
                <td class="px-4 py-2 text-right">{{ $kriteria ->idKriteria}}</td>
                <td class="px-4 py-2 text-right">{{ $kriteria->namaKriteria }}</td>
                <td class="px-4 py-2 text-right">{{ $kriteria->bobot }}</td>
              <td class="px-4 py-2 text-center">
                <div class="flex justify-center gap-2">
                    <a href="{{ route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria]) }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm">
                        ✏️ Detail
                      </a>
                  {{-- <form id="delete-form-{{ $kriteria->idKriteria }}" action="{{ route('kriteria.destroy', $kriteria->idKriteria) }}" method="POST" class="inline">
                    @csrf
                    <button type="button" onclick="confirmDelete({{ $kriteria->idKriteria }})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                      🗑 Hapus
                    </button>
                  </form> --}}
                </div>
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
 </div>


@endsection

