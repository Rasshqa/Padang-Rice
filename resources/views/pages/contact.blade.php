@extends('layouts.app')

@section('title', 'Kontak Kami - Padang Rice')

@section('content')
<x-hero title="KONTAK KAMI" />

<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="hero-title text-2xl md:text-3xl mb-10">KONTAK KAMI</h2>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="mb-16">
            @csrf
            <div class="flex flex-col lg:flex-row gap-6 mb-6">
                <!-- Left column -->
                <div class="flex-1 space-y-4">
                    <div>
                        <input type="text" name="subject" placeholder="Subject" 
                               class="w-full px-5 py-4 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors @error('subject') border-red-500 @enderror"
                               value="{{ old('subject') }}" required>
                        @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="name" placeholder="Name" 
                               class="w-full px-5 py-4 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors @error('name') border-red-500 @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" 
                               class="w-full px-5 py-4 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors @error('email') border-red-500 @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right column -->
                <div class="flex-1">
                    <textarea name="message" placeholder="Message" 
                              class="w-full h-full min-h-[200px] px-5 py-4 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors resize-none @error('message') border-red-500 @enderror"
                              required>{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-black text-white font-bold tracking-widest text-sm hover:bg-gray-800 transition-colors">KIRIM PESAN</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-display font-bold uppercase mb-2">EMAIL</h3>
                <p class="text-sm text-gray-600">padangrice@gmail.com</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h3 class="font-display font-bold uppercase mb-2">PHONE</h3>
                <p class="text-sm text-gray-600">+62 812 3456 7890</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="font-display font-bold uppercase mb-2">LOCATION</h3>
                <p class="text-sm text-gray-600">Kota Bandung, Jawa Barat</p>
            </div>
        </div>
    </div>
</section>

<section class="pb-0">
    <div class="w-full h-96 bg-gray-200">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15864.0!2d{{ $longitude }}!3d{{ $latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwNTUnMDEuNSJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>
@endsection
