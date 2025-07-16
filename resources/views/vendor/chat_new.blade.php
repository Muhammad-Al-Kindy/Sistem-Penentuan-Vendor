@extends('layouts.appvendor')

@section('title', 'Chat dengan Admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Chat dengan Admin</h1>

        <div class="mb-4">
            <p class="text-gray-600">
                Anda sedang membuka chat terkait laporan <strong>ID: {{ $reportId ?? 'N/A' }}</strong>
            </p>

        </div>

        <div class="bg-white rounded-lg shadow p-6 flex flex-col">


            <div id="chat-container" class="border rounded-lg p-4 h-64 overflow-y-auto bg-gray-50 mb-4">
                {{-- Chat messages will be appended here dynamically --}}
            </div>

            <form id="chat-form" onsubmit="return false;">
                <div class="flex gap-2">
                    <input type="text" id="message-input"
                        class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring focus:border-blue-400"
                        placeholder="Tulis pesan...">
                    <button type="button" id="send-button"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Kirim
                    </button>

                </div>
            </form>
        </div>
    </div>
    @vite('resources/js/chatVendor.js')

@endsection

@push('scripts')
    <script>
        window.authUserId = {{ auth()->user()->idUser }};
        window.chatPartnerId = {{ $admin->idUser }};
        window.nonConformanceId = @json($nonConformanceId);
    </script>
@endpush
