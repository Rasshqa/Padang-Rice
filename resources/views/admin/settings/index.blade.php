@extends('layouts.admin')

@section('header', 'Pengaturan')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Informasi Umum</h2>
        <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Brand</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'PADANG RICE') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="site_description" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="location" value="{{ old('location', $settings['location'] ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            
            <h3 class="text-md font-bold mb-3 mt-6 pt-4 border-t">Lokasi di Peta (Halaman Kontak)</h3>
            <p class="text-sm text-gray-600 mb-3">Klik pada peta untuk menentukan lokasi restoran yang tampil di halaman kontak</p>
            <div id="map" class="h-80 rounded-lg border border-gray-300 mb-3"></div>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                    <input type="number" step="any" name="contact_latitude" id="contact_latitude" value="{{ old('contact_latitude', $settings['contact_latitude'] ?? '-6.9175') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                    <input type="number" step="any" name="contact_longitude" id="contact_longitude" value="{{ old('contact_longitude', $settings['contact_longitude'] ?? '107.6191') }}" required class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            
            <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map, marker;

document.addEventListener('DOMContentLoaded', function() {
    const lat = parseFloat(document.getElementById('contact_latitude').value) || -6.9175;
    const lng = parseFloat(document.getElementById('contact_longitude').value) || 107.6191;
    
    map = L.map('map').setView([lat, lng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    marker = L.marker([lat, lng]).addTo(map);
    
    map.on('click', function(e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('contact_latitude').value = e.latlng.lat.toFixed(7);
        document.getElementById('contact_longitude').value = e.latlng.lng.toFixed(7);
    });
    
    document.getElementById('contact_latitude').addEventListener('change', updateMarker);
    document.getElementById('contact_longitude').addEventListener('change', updateMarker);
});

function updateMarker() {
    const lat = parseFloat(document.getElementById('contact_latitude').value);
    const lng = parseFloat(document.getElementById('contact_longitude').value);
    if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 13);
    }
}
</script>
@endsection
