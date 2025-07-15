@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Halaman Chat</h1>

    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col h-[500px]">
        <!-- Area Chat -->
        <div class="flex-1 overflow-y-auto border border-gray-200 rounded-md p-4 space-y-4" id="chat-box">
            <!-- Chat Admin -->
            <div class="flex flex-col items-start">
                <div class="bg-gray-200 px-4 py-2 rounded-lg text-sm text-gray-800">
                    Selamat pagi, ada yang bisa kami bantu?
                </div>
                <span class="text-xs text-gray-500 mt-1">Admin - 08:00</span>
            </div>

            <!-- Chat User -->
            <div class="flex flex-col items-end">
                <div class="bg-blue-500 px-4 py-2 rounded-lg text-sm text-white">
                    Saya ingin menanyakan status PO terbaru.
                </div>
                <span class="text-xs text-gray-500 mt-1">Anda - 08:02</span>
            </div>
        </div>

        <!-- Form Input Pesan -->
        <div class="mt-4 flex space-x-3">
            <input type="text" placeholder="Ketik pesan..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Kirim</button>
        </div>
    </div>
</div>
@endsection
