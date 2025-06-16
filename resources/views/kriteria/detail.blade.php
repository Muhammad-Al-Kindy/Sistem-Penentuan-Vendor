@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')
    <div class="container mx-auto mt-6 px-4">
        <div class="bg-white shadow-md rounded p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Tambah Kriteria</h2>
            </div>

            <div class="overflow-x-auto">
                <form action="{{ route('kriteria.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-lg font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-500"
                            required>
                    </div>

                    <!-- Bobot -->
                    <div>
                        <label for="bobot" class="block text-lg font-medium text-gray-700 mb-1">Bobot</label>
                        <input type="number" step="0.01" name="bobot" id="bobot"
                            class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-500"
                            required>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                            Buat Kriteria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
