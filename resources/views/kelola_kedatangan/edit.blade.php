@extends('layouts.app')

@section('title', 'Edit Kedatangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Kedatangan</h1>
    <form action="#" method="POST" class="space-y-6">
        <div>
            <label class="block mb-1 font-medium text-gray-700">Nama Perusahaan</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" value="PT Sinar Terang">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Nama Barang</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" value="Kabel Listrik 20m">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Tanggal</label>
            <input type="date" class="w-full border border-gray-300 rounded px-4 py-2" value="2025-06-21">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
