@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="flex w-full h-screen">
        <!-- Left Image Panel -->
        <div class="w-1/2 h-full hidden md:block">
            <img src="{{ asset('assets/train_structrue.png') }}" alt="Structure" class="h-full w-full object-cover">
        </div>

        <!-- Right Login Panel -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="w-full px-8">
                <h2 class="text-3xl font-semibold text-center mb-8">Login</h2>

                @if (session('error'))
                    <div class="mb-4 text-red-600 text-center">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 rounded-full bg-gray-200 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required autofocus>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 rounded-full bg-gray-200 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                            class="w-full bg-gray-800 text-white rounded-full py-2 hover:bg-black transition">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
