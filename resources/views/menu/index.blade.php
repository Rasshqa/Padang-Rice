@extends('layouts.app')

@section('title', 'Menu Kami – Padang Rice')

@section('content')
{{-- Toast Notification --}}
<div id="toast" class="fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-gray-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl translate-x-[120%] transition-all duration-500 ease-out max-w-xs">
    <div id="toast-icon" class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
    </div>
    <p id="toast-msg" class="text-sm font-medium leading-snug"></p>
</div>

{{-- Checkout Sidebar Overlay --}}
<div id="checkout-overlay" class="fixed inset-0 bg-black/50 z-[100] hidden transition-opacity" onclick="closeCheckout()"></div>

{{-- Checkout Sidebar --}}
<div id="checkout-sidebar" class="fixed top-0 right-0 h-full w-full md:w-[480px] bg-white z-[101] transform translate-x-full transition-transform duration-300 shadow-2xl overflow-y-auto">
    <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
        <h2 class="font-bold text-gray-900 text-lg">Checkout</h2>
        <button onclick="closeCheckout()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div id="checkout-content" class="p-6 pb-32">
        <div id="empty-cart-msg" class="text-center py-12 hidden">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <p class="text-gray-500 text-sm">Keranjang kosong</p>
            <p class="text-gray-400 text-xs mt-1">Pilih menu untuk memulai pesanan</p>
        </div>

        <form id="checkoutForm" action="{{ route('menu.checkout') }}" method="POST" class="space-y-5 hidden">
            @csrf
            
            {{-- Cart Items --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Pesanan Anda</h3>
                <div id="checkout-cart-items" class="space-y-2 mb-3"></div>
                <div class="border-t border-gray-200 pt-3 space-y-1.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span id="checkout-subtotal" class="font-semibold">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkir</span>
                        <span id="checkout-delivery-fee" class="font-semibold">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-yellow-700 pt-2 border-t">
                        <span>Total</span>
                        <span id="checkout-total">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- Customer Data --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Nama Lengkap *</label>
                <input type="text" name="customer_name" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                       placeholder="Masukkan nama lengkap">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Email *</label>
                    <input type="email" name="customer_email" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="email@contoh.com">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">No. Telepon *</label>
                    <input type="text" name="customer_phone" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition outline-none"
                           placeholder="08xxx">
                </div>
            </div>

            {{-- Delivery Method --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Metode Pengiriman *</label>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <label id="label-pickup" onclick="setDelivery('pickup')" class="relative flex flex-col gap-2 p-3 border-2 border-yellow-500 bg-yellow-50 rounded-xl cursor-pointer transition">
                        <input type="radio" name="delivery_method" value="pickup" checked class="sr-only">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-sm text-gray-900">Ambil Sendiri</span>
                            <div id="check-pickup" class="w-4 h-4 rounded-full border-2 border-yellow-500 flex items-center justify-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            </div>
                        </div>
                        <span class="text-xs text-green-600 font-bold">Gratis</span>
                    </label>

                    <label id="label-delivery" onclick="setDelivery('delivery')" class="relative flex flex-col gap-2 p-3 border-2 border-gray-200 rounded-xl cursor-pointer transition hover:border-yellow-300">
                        <input type="radio" name="delivery_method" value="delivery" class="sr-only">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-sm text-gray-900">Diantar</span>
                            <div id="check-delivery" class="w-4 h-4 rounded-full border-2 border-gray-300 hidden"></div>
                        </div>
                        <span class="text-xs text-orange-600 font-bold">+Rp 10.000</span>
                    </label>
                </div>

                {{-- Delivery Address Fields --}}
                <div id="delivery-fields" class="hidden space-y-3">
                    <div class="relative">
                        <input type="text" id="address-input" name="delivery_address"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-28 text-sm focus:ring-2 focus:ring-yellow-500 transition outline-none"
                               placeholder="Cari atau ketik alamat"
                               autocomplete="off">
                        <button type="button" onclick="getCurrentLocation()" id="loc-btn"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-semibold rounded-lg transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lokasi
                        </button>
                        <div id="suggestions" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto z-20"></div>
                    </div>
                    <div id="map" class="h-48 rounded-xl border border-gray-200 overflow-hidden"></div>
                    <p class="text-xs text-gray-400">Klik peta atau geser marker</p>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Catatan (opsional)</label>
                <textarea name="notes" rows="2"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-500 transition outline-none resize-none"
                          placeholder="Contoh: Tidak pakai sambal..."></textarea>
            </div>

            {{-- Submit Button --}}
            <button type="submit" id="submitBtn"
                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3.5 rounded-xl transition shadow-sm text-base">
                Buat Pesanan →
            </button>
        </form>
    </div>
</div>

{{-- Floating Checkout Button --}}
<button id="floating-checkout-btn" onclick="openCheckout()" class="hidden fixed bottom-6 right-6 z-50 bg-yellow-600 hover:bg-yellow-700 text-white font-bold px-6 py-4 rounded-full shadow-2xl transition-all flex items-center gap-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
    <span>Checkout</span>
    <span id="floating-cart-count" class="w-6 h-6 bg-white text-yellow-700 rounded-full flex items-center justify-center text-xs font-bold"></span>
</button>

<div class="min-h-screen bg-[#f5f4f1] pt-20">

    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-100 py-8 px-4">
        <div class="max-w-[1280px] mx-auto flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                {{-- Breadcrumb --}}
                <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
                    <a href="{{ route('home') }}" class="hover:text-yellow-600 transition">Home</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-700 font-medium">Menu Lengkap</span>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-display">Menu Lengkap</h1>
                <p class="text-gray-500 mt-1">
                    <span class="font-semibold text-yellow-700">{{ $menus->total() }}</span> hidangan khas Minangkabau tersedia
                </p>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('menu.index') }}" id="searchForm" class="flex w-full md:w-auto md:max-w-md">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('price_min')) <input type="hidden" name="price_min" value="{{ request('price_min') }}"> @endif
                @if(request('price_max')) <input type="hidden" name="price_max" value="{{ request('price_max') }}"> @endif
                <div class="flex w-full border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm focus-within:ring-2 focus-within:ring-yellow-500 focus-within:border-transparent transition-all">
                    <span class="pl-4 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari menu, rendang, gulai..."
                           class="flex-1 px-3 py-3 text-sm outline-none bg-transparent text-gray-700 placeholder-gray-400">
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-3 font-semibold text-sm transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-4 py-8 flex gap-8">

        {{-- ===== SIDEBAR FILTER ===== --}}
        <aside class="w-[220px] shrink-0 hidden lg:block">
            <form method="GET" action="{{ route('menu.index') }}" id="filterForm">
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                <div class="bg-white rounded-xl border border-gray-200 p-5 sticky top-24">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-bold text-gray-900 text-base">Filter</h2>
                        @if(request('category') || request('price_min') || request('price_max'))
                            <a href="{{ route('menu.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" class="text-xs text-yellow-600 hover:text-yellow-700 font-medium transition">Hapus Semua</a>
                        @endif
                    </div>

                    {{-- Category --}}
                    <div class="mb-6">
                        <h3 class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-3">Kategori</h3>
                        <div class="space-y-2">
                            @php
                                $categories = [
                                    '' => 'Semua Menu',
                                    'lauk' => 'Lauk Pauk',
                                    'sayur' => 'Sayur & Pelengkap',
                                    'nasi' => 'Nasi',
                                    'minuman' => 'Minuman',
                                ];
                            @endphp
                            @foreach($categories as $val => $label)
                                @php
                                    $active = request('category', '') === $val;
                                @endphp
                                <label class="block cursor-pointer">
                                    <input type="radio" name="category" value="{{ $val }}"
                                           {{ $active ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit()"
                                           class="sr-only peer">
                                    <span class="flex items-center gap-2.5 px-3 py-2 text-sm rounded-lg border transition-all
                                          {{ $active
                                              ? 'bg-yellow-600 border-yellow-600 text-white font-semibold shadow-sm'
                                              : 'bg-white border-gray-200 text-gray-700 hover:border-yellow-400 hover:bg-yellow-50'
                                          }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $active ? 'bg-white' : 'bg-gray-300' }}"></span>
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="mb-2">
                        <h3 class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-3">Kisaran Harga</h3>
                        <div class="space-y-3">
                            <div class="relative">
                                <input type="range" id="priceRange" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1000"
                                       value="{{ request('price_max', $maxPrice) }}"
                                       class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-yellow-600"
                                       oninput="document.getElementById('priceDisplay').textContent = 'Maks: Rp ' + parseInt(this.value).toLocaleString('id-ID')">
                                <div class="flex justify-between text-[11px] text-gray-500 mt-2">
                                    <span>Rp {{ number_format($minPrice, 0, ',', '.') }}</span>
                                    <span>Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div id="priceDisplay" class="text-sm font-semibold text-gray-900 bg-gray-50 rounded-md px-3 py-2 text-center">
                                Maks: Rp {{ number_format(request('price_max', $maxPrice), 0, ',', '.') }}
                            </div>
                            <input type="hidden" name="price_max" id="priceMaxInput" value="{{ request('price_max', $maxPrice) }}">
                            <button type="button" onclick="applyPrice()" class="w-full bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2 rounded-lg transition">
                                Terapkan
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="category" id="hiddenCategory" value="{{ request('category', '') }}">
                </div>
            </form>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 min-w-0">

            {{-- Mobile Category Tabs --}}
            <div class="lg:hidden flex gap-2 overflow-x-auto pb-2 mb-6 scrollbar-hide -mx-1 px-1">
                @foreach(['' => 'Semua', 'lauk' => 'Lauk', 'sayur' => 'Sayur', 'nasi' => 'Nasi', 'minuman' => 'Minuman'] as $val => $label)
                    @php
                        $mobileActive = request('category', '') === $val;
                    @endphp
                    <a href="{{ route('menu.index', array_filter(['category' => $val, 'search' => request('search'), 'sort' => request('sort')])) }}"
                       class="shrink-0 px-4 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ $mobileActive ? 'bg-yellow-600 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:border-yellow-400' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Toolbar: Count + Sort --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-800">{{ $menus->firstItem() }}–{{ $menus->lastItem() }}</span> dari <span class="font-semibold text-gray-800">{{ $menus->total() }}</span> menu
                </p>
                <div class="relative">
                    <select onchange="sortMenu(this.value)"
                            class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-9 py-2 text-sm font-medium text-gray-700 cursor-pointer focus:ring-2 focus:ring-yellow-500 focus:border-transparent shadow-sm">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>Terpopuler</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>A – Z</option>
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            @if($menus->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 12h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-gray-700 font-bold text-lg mb-1">Menu Tidak Ditemukan</h3>
                    <p class="text-gray-500 text-sm">Coba filter atau kata kunci lain</p>
                </div>
            @else
                {{-- Menu Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($menus as $menu)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden flex flex-col shadow-sm hover:shadow-lg transition-shadow duration-300 group">
                            {{-- IMAGE — fixed 240px height --}}
                            <div class="relative h-60 overflow-hidden bg-gray-100">
                                <a href="{{ route('menu.show', $menu) }}">
                                    <img src="{{ $menu->image ?? 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400' }}"
                                         alt="{{ $menu->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy"
                                         onerror="this.src='https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400'">
                                </a>

                                @if($menu->order_count > 20)
                                    <span class="absolute top-3 left-3 bg-[#7B2E2E] text-white text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-md">Bestseller</span>
                                @elseif($menu->id > ($totalMenus - 8))
                                    <span class="absolute top-3 left-3 bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-md">Baru</span>
                                @endif

                                @if(!$menu->available)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-white/95 text-gray-900 text-xs font-bold px-4 py-1.5 rounded-md">Habis</span>
                                    </div>
                                @endif

                                <button class="absolute top-3 right-3 w-8 h-8 bg-white/95 rounded-full flex items-center justify-center shadow opacity-0 group-hover:opacity-100 transition-opacity duration-200 active:scale-90"
                                        onclick="event.preventDefault(); wishlistToggle(this)">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </button>
                            </div>

                            {{-- INFO — 16px padding, flexible height --}}
                            <div class="p-4 flex flex-col flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">{{ $menu->categoryLabel }}</span>
                                    @if($menu->available)
                                        <span class="text-[10px] text-green-700 font-medium bg-green-50 px-2 py-0.5 rounded-full">Tersedia</span>
                                    @else
                                        <span class="text-[10px] text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded-full">Habis</span>
                                    @endif
                                </div>

                                <a href="{{ route('menu.show', $menu) }}" class="block mb-2">
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight hover:text-yellow-700 transition-colors line-clamp-1">{{ $menu->name }}</h3>
                                </a>

                                <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-4">{{ $menu->description }}</p>

                                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                                    <span class="text-gray-900 font-bold text-base">{{ $menu->formattedPrice }}</span>

                                    @if($menu->available)
                                        <button onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                                                class="cart-btn-{{ $menu->id }} px-3 py-1.5 bg-gray-900 hover:bg-yellow-600 active:bg-yellow-700 text-white text-xs font-semibold rounded-md flex items-center gap-1 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($menus->hasPages())
                    <div class="mt-12 flex justify-center">
                        <div class="bg-white rounded-xl border border-gray-200 px-4 py-2 inline-flex items-center gap-1">
                            {{ $menus->appends(request()->query())->links('vendor.pagination.padang') }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const CART_AJAX_URL = '{{ route('cart.add.ajax') }}';
const CSRF_TOKEN = '{{ csrf_token() }}';
const DELIVERY_FEE = 10000;

let map, marker, searchTimeout;
let currentDelivery = 'pickup';
        toast.classList.add('translate-x-[120%]');
    }, 3000);
}

function wishlistToggle(btn) {
    const svg = btn.querySelector('svg');
    const filled = btn.dataset.liked === '1';
    if (filled) {
        btn.dataset.liked = '';
        svg.setAttribute('fill', 'none');
    } else {
        btn.dataset.liked = '1';
        svg.setAttribute('fill', '#ef4444');
    }
}

function sortMenu(val) {
    const url = new URL(window.location.href);
    if (val) url.searchParams.set('sort', val);
    else url.searchParams.delete('sort');
    window.location = url.toString();
}

function applyPrice() {
    const val = document.getElementById('priceRange').value;
    document.getElementById('priceMaxInput').value = val;
    document.getElementById('filterForm').submit();
}
</script>
@endsection
let cartData = @json(session('cart', []));
let cartMenuData = @json($cartWithMenus);

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCheckoutUI();
});

function addToCart(menuId, menuName) {
    const btn = document.querySelector('.cart-btn-' + menuId);
    if (!btn) return;

    btn.innerHTML = `<svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;
    btn.disabled = true;

    fetch(CART_AJAX_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ menu_id: menuId, quantity: 1 }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            updateCartBadge(data.cart_count);
            
            // Reload page to refresh cart data
            location.reload();
        } else {
            showToast(data.message, 'error');
            resetBtn(btn);
        }
    })
    .catch(() => {
        showToast('Gagal menambahkan ke keranjang', 'error');
        resetBtn(btn);
    });
}

function resetBtn(btn) {
    btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah`;
    btn.disabled = false;
}

function updateCartBadge(count) {
    const badges = document.querySelectorAll('[data-cart-badge]');
    badges.forEach(b => {
        b.textContent = count;
        b.classList.toggle('hidden', count <= 0);
    });

    const navBadge = document.querySelector('nav a[href*="keranjang"] span');
    if (navBadge) {
        navBadge.textContent = count;
        navBadge.classList.toggle('hidden', count <= 0);
    }

    const floatingCount = document.getElementById('floating-cart-count');
    if (floatingCount) floatingCount.textContent = count;
}

function updateCheckoutUI() {
    const isEmpty = Object.keys(cartMenuData).length === 0;
    const floatingBtn = document.getElementById('floating-checkout-btn');
    const emptyMsg = document.getElementById('empty-cart-msg');
    const checkoutForm = document.getElementById('checkoutForm');
    const floatingCount = document.getElementById('floating-cart-count');

    if (isEmpty) {
        floatingBtn.classList.add('hidden');
        emptyMsg.classList.remove('hidden');
        checkoutForm.classList.add('hidden');
    } else {
        floatingBtn.classList.remove('hidden');
        emptyMsg.classList.add('hidden');
        checkoutForm.classList.remove('hidden');
        floatingCount.textContent = Object.keys(cartMenuData).length;
        renderCheckoutCart();
    }
}

function renderCheckoutCart() {
    const container = document.getElementById('checkout-cart-items');
    let html = '';
    let subtotal = 0;

    Object.entries(cartMenuData).forEach(([menuId, item]) => {
        const menu = item.menu;
        const quantity = item.quantity;
        const itemTotal = menu.price * quantity;
        subtotal += itemTotal;
        
        html += `
            <div class="flex items-center gap-2 text-xs">
                <span class="flex-1 font-semibold text-gray-900">${quantity}x ${menu.name}</span>
                <span class="font-bold">Rp ${itemTotal.toLocaleString('id-ID')}</span>
            </div>
        `;
    });

    container.innerHTML = html;
    
    const deliveryFee = currentDelivery === 'delivery' ? DELIVERY_FEE : 0;
    const total = subtotal + deliveryFee;

    document.getElementById('checkout-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('checkout-delivery-fee').textContent = 'Rp ' + deliveryFee.toLocaleString('id-ID');
    document.getElementById('checkout-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function openCheckout() {
    if (Object.keys(cartMenuData).length === 0) {
        showToast('Keranjang kosong', 'error');
        return;
    }
    document.getElementById('checkout-overlay').classList.remove('hidden');
    document.getElementById('checkout-sidebar').classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden';
}

function closeCheckout() {
    document.getElementById('checkout-overlay').classList.add('hidden');
    document.getElementById('checkout-sidebar').classList.add('translate-x-full');
    document.body.style.overflow = '';
}

function setDelivery(method) {
    currentDelivery = method;

    document.querySelectorAll('input[name="delivery_method"]').forEach(r => {
        r.checked = r.value === method;
    });

    ['pickup', 'delivery'].forEach(m => {
        const label = document.getElementById('label-' + m);
        const check = document.getElementById('check-' + m);
        if (m === method) {
            label.classList.add('border-yellow-500', 'bg-yellow-50');
            label.classList.remove('border-gray-200');
            check.classList.remove('hidden');
            check.innerHTML = '<div class="w-2 h-2 bg-yellow-500 rounded-full"></div>';
        } else {
            label.classList.remove('border-yellow-500', 'bg-yellow-50');
            label.classList.add('border-gray-200');
            check.classList.add('hidden');
        }
    });

    const deliveryFields = document.getElementById('delivery-fields');
    deliveryFields.classList.toggle('hidden', method !== 'delivery');

    renderCheckoutCart();

    if (method === 'delivery' && !map) {
        setTimeout(initMap, 100);
    } else if (map) {
        setTimeout(() => map.invalidateSize(), 100);
    }
}

function initMap() {
    const defaultLat = -6.9175, defaultLng = 107.6191;
    map = L.map('map').setView([defaultLat, defaultLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    map.on('click', e => {
        setMarker(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function setMarker(lat, lng) {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    marker.on('dragend', onMarkerDrag);
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}

function onMarkerDrag(e) {
    const pos = e.target.getLatLng();
    document.getElementById('latitude').value = pos.lat;
    document.getElementById('longitude').value = pos.lng;
    reverseGeocode(pos.lat, pos.lng);
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(r => r.json())
        .then(data => {
            if (data.display_name) document.getElementById('address-input').value = data.display_name;
        }).catch(() => {});
}

function getCurrentLocation() {
    if (!navigator.geolocation) return alert('Geolocation tidak didukung');
    const btn = document.getElementById('loc-btn');
    btn.innerHTML = `<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>`;
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        pos => {
            setMarker(pos.coords.latitude, pos.coords.longitude);
            map.setView([pos.coords.latitude, pos.coords.longitude], 15);
            reverseGeocode(pos.coords.latitude, pos.coords.longitude);
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Lokasi`;
            btn.disabled = false;
        },
        () => {
            alert('Tidak dapat mengakses lokasi');
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Lokasi`;
            btn.disabled = false;
        }
    );
}

document.getElementById('address-input')?.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const query = e.target.value;
    if (query.length < 3) {
        document.getElementById('suggestions').classList.add('hidden');
        return;
    }
    searchTimeout = setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
            .then(r => r.json())
            .then(data => {
                const sug = document.getElementById('suggestions');
                if (!data.length) { sug.classList.add('hidden'); return; }
                sug.innerHTML = data.map(item =>
                    `<div class="px-4 py-2 hover:bg-yellow-50 cursor-pointer border-b last:border-0 text-xs"
                          onclick="selectPlace(${item.lat}, ${item.lon}, '${item.display_name.replace(/'/g, "\\'")}')">
                        ${item.display_name}
                    </div>`
                ).join('');
                sug.classList.remove('hidden');
            }).catch(() => {});
    }, 500);
});

function selectPlace(lat, lng, address) {
    document.getElementById('address-input').value = address;
    document.getElementById('suggestions').classList.add('hidden');
    setMarker(lat, lng);
    map.setView([lat, lng], 15);
}

document.addEventListener('click', e => {
    if (!e.target.closest('#address-input') && !e.target.closest('#suggestions')) {
        document.getElementById('suggestions')?.classList.add('hidden');
    }
});

document.getElementById('checkoutForm').addEventListener('submit', () => {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = `<svg class="w-5 h-5 animate-spin inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Memproses...`;
    btn.disabled = true;
});

function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-msg');
    const toastIcon = document.getElementById('toast-icon');

    toastMsg.textContent = msg;
    if (type === 'success') {
        toastIcon.className = 'w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center shrink-0';
        toastIcon.innerHTML = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`;
    } else {
        toastIcon.className = 'w-8 h-8 bg-red-500 rounded-full flex items-center justify-center shrink-0';
        toastIcon.innerHTML = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
    }

    toast.classList.remove('translate-x-[120%]');
    toast.classList.add('translate-x-0');

    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(() => {
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-[120%]');
    }, 3000);
}

function wishlistToggle(btn) {
    const svg = btn.querySelector('svg');
    const filled = btn.dataset.liked === '1';
    if (filled) {
        btn.dataset.liked = '';
        svg.setAttribute('fill', 'none');
    } else {
        btn.dataset.liked = '1';
        svg.setAttribute('fill', '#ef4444');
    }
}

function sortMenu(val) {
    const url = new URL(window.location.href);
    if (val) url.searchParams.set('sort', val);
    else url.searchParams.delete('sort');
    window.location = url.toString();
}

function applyPrice() {
    const val = document.getElementById('priceRange').value;
    document.getElementById('priceMaxInput').value = val;
    document.getElementById('filterForm').submit();
}
</script>
