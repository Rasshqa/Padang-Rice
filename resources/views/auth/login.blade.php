@extends('layouts.app')

@section('title', 'Login - Padang Rice')

@section('content')
<div class="min-h-screen bg-[#f5f4f1] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 font-display">Login</h1>
            <p class="text-gray-600 mt-2">Masuk ke akun Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Email</label>
                    <input type="email" name="email" required autofocus
                           value="{{ old('email') }}"
                           class="w-full border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="email@contoh.com">
                    @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="Masukkan password">
                    @error('password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl transition">
                    Masuk
                </button>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold">Daftar</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
