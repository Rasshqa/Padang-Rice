@extends('layouts.app')

@section('title', 'Daftar - Padang Rice')

@section('content')
<div class="min-h-screen bg-[#f5f4f1] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 font-display">Daftar</h1>
            <p class="text-gray-600 mt-2">Buat akun baru Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required autofocus
                           value="{{ old('name') }}"
                           class="w-full border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="Nama lengkap Anda">
                    @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Email</label>
                    <input type="email" name="email" required
                           value="{{ old('email') }}"
                           class="w-full border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="email@contoh.com">
                    @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">No. WhatsApp</label>
                    <input type="text" name="phone" required
                           value="{{ old('phone') }}"
                           class="w-full border {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="Ketik ulang password">
                </div>

                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-xl transition">
                    Daftar
                </button>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold">Masuk</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
