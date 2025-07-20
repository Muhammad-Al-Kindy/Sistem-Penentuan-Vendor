@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('users.index') }}" class="hover:underline">Manajemen Pengguna</a>
            <span class="mx-2">/</span>
            <span>Edit Pengguna</span>
        </nav>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Pengguna</h1>
            </div>

            <!-- Form -->
            <form action="{{ route('users.update', $user->idUser) }}" method="POST" data-update-user-form
                data-redirect-url="/users" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="Admin" {{ strtolower(old('role', $user->role)) == 'admin' ? 'selected' : '' }}>Admin
                        </option>

                        <option value="Vendor" {{ strtolower(old('role', $user->role)) == 'vendor' ? 'selected' : '' }}>
                            Vendor
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('users.index') }}"
                        class="mr-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-700 font-semibold">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 rounded hover:bg-indigo-700 text-white font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
