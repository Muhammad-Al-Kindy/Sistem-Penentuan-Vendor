@extends('layouts.app')

@section('title', 'Chat dengan Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Chat dengan Admin</h1>

    <div class="mb-4">
        <p class="text-gray-600">Anda sedang membuka chat terkait laporan <strong>ID: {{ $reportId }}</strong></p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4 text-gray-500 italic">
            (Simulasi tampilan chat — isi dan percakapan dapat diatur nanti)
        </div>

        <div class="border rounded-lg p-4 h-64 overflow-y-auto bg-gray-50 mb-4">
            {{-- Chat history bisa ditampilkan di sini --}}
            <p><strong>Admin:</strong> Silakan jelaskan detail masalahnya.</p>
            <p><strong>Vendor:</strong> Ada baut longgar yang harus diperiksa.</p>
        </div>

        <form>
            <div class="flex gap-2">
                <input type="text" class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring focus:border-blue-400"
                    placeholder="Tulis pesan...">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
