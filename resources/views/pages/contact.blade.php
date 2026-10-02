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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="subject" placeholder="Subject" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand/50 @error('subject') border-red-500 @enderror"
                           value="{{ old('subject') }}" required>
                    @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="text" name="name" placeholder="Name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand/50 @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="email" name="email" placeholder="Email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand/50 @error('email') border-red-500 @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <textarea name="message" placeholder="Message" rows="6" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand/50 resize-none @error('message') border-red-500 @enderror"
                              required>{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-dark w-full text-center">KIRIM</button>
            </form>

            <div></div>
        </div>

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
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56211042336!2d107.57311709726562!3d-6.903444199999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1234567890" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>
@endsection
