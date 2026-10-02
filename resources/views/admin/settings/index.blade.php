@extends('layouts.admin')

@section('header', 'Pengaturan')

@section('content')
<div class="max-w-2xl">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Brand</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'PADANG RICE') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="site_description" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $settings['location'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
