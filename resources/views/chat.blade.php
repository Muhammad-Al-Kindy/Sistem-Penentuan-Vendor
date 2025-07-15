@extends('layouts.app')

@section('title', 'Halaman Chat')

@section('content')
<div class="flex max-w-7xl mx-auto px-4 py-8 gap-6">
    <!-- Sidebar User List -->
    <div class="w-1/4 border-r border-gray-200/60 pr-4"> {{-- Transparansi di sini --}}
        <h2 class="text-lg font-semibold text-blue-700 mb-4">Daftar Penerima</h2>

        <ul class="space-y-2">
            <li>
                <a href="#"
                   class="flex justify-between items-center p-3 rounded-md border border-gray-300/50 hover:bg-blue-50 transition bg-white">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-circle text-gray-500"></i>
                        <span>Nama Pengguna 1</span>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-gray-300 text-gray-700">Belum</span>
                </a>
            </li>
            <li>
                <a href="#"
                   class="flex justify-between items-center p-3 rounded-md border border-gray-300/50 hover:bg-blue-50 transition bg-blue-100 font-semibold text-blue-700">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-circle text-gray-500"></i>
                        <span>Nama Pengguna 2</span>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-green-400 text-white">Sudah</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Chat Area -->
    <div class="w-3/4">
        <div class="flex items-center mb-4 pb-2 border-b border-gray-300/50">
            <img src="https://ui-avatars.com/api/?name=Nama+Pengguna+2&background=0D8ABC&color=fff"
                 alt="Avatar" class="rounded-full w-10 h-10 mr-3">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Chat dengan Nama Pengguna 2</h3>
                <p class="text-sm text-gray-500">Silakan kirim pesan untuk vendor</p>
            </div>
        </div>

        <div class="text-sm text-gray-500 mb-2">Memuat pesan...</div>
        <div class="border border-gray-300/50 rounded p-4 h-96 overflow-y-auto mb-4 space-y-2 bg-gray-50">
            <!-- Chat Admin -->
            <div class="bg-gray-200 text-left px-3 py-2 rounded text-sm max-w-[75%]">
                Halo, saya ingin menanyakan status PO terbaru.
            </div>

            <!-- Chat User -->
            <div class="bg-blue-100 text-right px-3 py-2 rounded text-sm max-w-[75%] ml-auto">
                Tentu, PO #123 sedang diproses.
            </div>
        </div>

        <form class="space-y-2">
            <div class="flex space-x-2">
                <input type="text"
                       class="flex-1 border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Tulis pesan...">
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Kirim</button>
            </div>
        </form>

        <button type="button"
                onclick="window.history.back()"
                class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg border border-gray-300 shadow-sm transition">
            ← Kembali
        </button>
    </div>
</div>
@endsection
