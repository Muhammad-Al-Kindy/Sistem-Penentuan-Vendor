@extends('layouts.appvendor')

@section('title', 'Chat dengan Admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Chat dengan Admin</h1>

        <div class="mb-4">
            <p class="text-gray-600">Anda sedang membuka chat terkait laporan <strong>ID: {{ $reportId ?? 'N/A' }}</strong>
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex flex-col">
            <div class="mb-4 text-gray-500 italic">
                (Chat messages will load dynamically)
            </div>

            <div id="chat-container" class="border rounded-lg p-4 h-64 overflow-y-auto bg-gray-50 mb-4">
                {{-- Chat messages will be appended here dynamically --}}
            </div>

            <form id="chat-form" onsubmit="return false;">
                <div class="flex gap-2">
                    <input type="text" id="message-input"
                        class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring focus:border-blue-400"
                        placeholder="Tulis pesan...">
                    <button type="submit" id="send-button"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.authUserId = {{ auth()->user()->idUser }};
        window.chatPartnerId = {{ $admin->idUser }};

        document.addEventListener("DOMContentLoaded", function() {
            // Clear localStorage.selectedVendorId to avoid overriding chatPartnerId
            localStorage.removeItem("selectedVendorId");
        });
    </script>
    <script src="{{ asset('js/chatVendor.js') }}"></script>
@endsection
