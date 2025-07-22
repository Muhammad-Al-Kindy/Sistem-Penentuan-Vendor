@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [['label' => 'Home', 'url' => ''], ['label' => 'Manajemen Pengguna', 'url' => '']];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengguna</h1>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 {{ $user->role == 'Admin' ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $user->role }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('users.edit', $user->idUser) }}"
                                    class="text-sm text-blue-500 hover:underline"> <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->idUser) }}" method="POST" class="inline"
                                    data-delete-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline ml-2" "
                                                    >Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
     @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            {{ $users->links() }}
        </div>
    </div>
@endsection
