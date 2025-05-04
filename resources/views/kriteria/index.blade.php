@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <div class="bg-white shadow-md rounded p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Data Kriteria</h2>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          <i class="ri-add-line mr-1"></i> Tambah
        </a>
      </div>

      <div class="mb-4">
        <input type="text" placeholder="Search" class="w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
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
            {{-- @foreach($kriterias as $index => $kriteria) --}}
            <tr class="odd:bg-yellow-700 even:bg-yellow-600">
                <td class="px-4 py-2 text-right">1</td>
                <td class="px-4 py-2 text-right">Kualitas</td>
                <td class="px-4 py-2 text-right">0.4</td>
              <td class="px-4 py-2 text-center">
                <div class="flex justify-center gap-2">
                  <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm">
                    ✏️ Edit
                  </a>
                  <form action="#" method="POST" onsubmit="return confirm('Hapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                      🗑 Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            <tr class="odd:bg-yellow-700 even:bg-yellow-600">
                <td class="px-4 py-2 text-right">1</td>
                <td class="px-4 py-2 text-right">Kualitas</td>
                <td class="px-4 py-2 text-right">0.4</td>
              <td class="px-4 py-2 text-center">
                <div class="flex justify-center gap-2">
                  <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm">
                    ✏️ Edit
                  </a>
                  <form action="#" method="POST" onsubmit="return confirm('Hapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                      🗑 Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            {{-- @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection

