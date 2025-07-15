@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="#" class="hover:underline">Home</a>
        <span class="mx-2">/</span>
        <span>Manajemen Pengguna</span>
    </nav>

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
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">Admin Reka</td>
                    <td class="px-6 py-4">admin@reka.com</td>
                    <td class="px-6 py-4 text-blue-600">Admin</td>
                    <td class="px-6 py-4">
                        <a href="#" class="text-sm text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-sm text-red-500 hover:underline ml-2">Hapus</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">User Umum</td>
                    <td class="px-6 py-4">user@example.com</td>
                    <td class="px-6 py-4 text-green-600">User</td>
                    <td class="px-6 py-4">
                        <a href="#" class="text-sm text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-sm text-red-500 hover:underline ml-2">Hapus</a>
                    </td>
                </tr>
                <!-- Tambahkan data lain di sini -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        <nav class="inline-flex items-center space-x-1 text-sm">
            <a href="#" class="px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-l">«</a>
            <a href="#" class="px-3 py-1 bg-blue-500 text-white font-semibold">1</a>
            <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 hover:bg-gray-300">2</a>
            <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-r">»</a>
        </nav>
    </div>
</div>
@endsection
