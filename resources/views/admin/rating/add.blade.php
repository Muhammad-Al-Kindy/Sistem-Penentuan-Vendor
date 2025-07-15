@extends('layouts.app')

@section('title', 'Tambah Rating')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Rating Vendor</h1>
    <form action="#" method="POST" class="space-y-6">
        <div>
            <label class="block mb-1 font-medium text-gray-700">Nama Perusahaan</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Nama Perusahaan">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Kualitas</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Baik/Cukup/Buruk">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Ketepatan Waktu</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Tepat/Lambat">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Kuantitas</label>
            <input type="text" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Sesuai/Tidak Sesuai">
        </div>
        <div class="flex justify-end gap-4 pt-2">
            <a href="javascript:void(0);" onclick="window.history.back()" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 shadow">
                ← Kembali
            </a>
        
            <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-900">
                Simpan
            </button>
        </div>
        
    </form>
</div>
@endsection
