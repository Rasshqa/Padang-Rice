@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Berita</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_news'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Foto</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_galleries'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pesan Masuk</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['unread_messages'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold">Berita Terbaru</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentNews as $news)
                <div class="flex items-start gap-4">
                    <img src="{{ asset($news->image ?? 'assets/ASET/nasipadang-hero.jpg') }}" 
                         alt="{{ $news->title }}" 
                         class="w-16 h-16 object-cover rounded">
                    <div class="flex-1">
                        <h3 class="font-medium text-sm">{{ Str::limit($news->title, 50) }}</h3>
                        <p class="text-xs text-gray-500">{{ $news->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">Belum ada berita.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold">Pesan Terbaru</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentMessages as $message)
                <div class="pb-4 border-b last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-medium text-sm">{{ $message->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $message->subject }}</p>
                        </div>
                        @if(!$message->is_read)
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Baru</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-500">Belum ada pesan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
