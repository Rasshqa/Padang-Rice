@php
$currentPage = request()->path();
$navLinks = [
    ['label' => 'HOME', 'url' => '/'],
    ['label' => 'TENTANG', 'url' => '/tentang'],
    ['label' => 'MENU', 'url' => '/menu'],
    ['label' => 'BERITA', 'url' => '/berita'],
    ['label' => 'GALERI', 'url' => '/galeri'],
    ['label' => 'PESANAN', 'url' => '/pesanan'],
    ['label' => 'KONTAK', 'url' => '/kontak'],
];
@endphp

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $transparent ?? false ? 'bg-transparent text-white' : 'bg-white/95 backdrop-blur-sm shadow-sm text-gray-900' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="/" class="text-lg font-bold tracking-wide font-display uppercase {{ $transparent ?? false ? 'text-white' : 'text-black' }}">
                PADANG RICE
            </a>

            <div class="hidden md:flex items-center gap-6">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}"
                       class="text-xs font-semibold tracking-widest uppercase transition-colors duration-200
                              {{ ($currentPage === ltrim($link['url'], '/') || ($link['url'] === '/' && $currentPage === '')) ? 'opacity-100' : 'opacity-70 hover:opacity-100' }}
                              {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('cart.index') }}" class="relative {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                @auth
                    <a href="{{ route('profile.show') }}" class="text-xs font-semibold tracking-widest uppercase {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }} opacity-70 hover:opacity-100">
                        PROFIL
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold tracking-widest uppercase {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }} opacity-70 hover:opacity-100">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold tracking-widest uppercase {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }} opacity-70 hover:opacity-100">
                        LOGIN
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-semibold tracking-widest uppercase {{ $transparent ?? false ? 'text-white' : 'text-gray-900' }} opacity-70 hover:opacity-100">
                        REGISTER
                    </a>
                @endauth
            </div>

            <button id="mobile-menu-btn" class="md:hidden p-2" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-2">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" class="block py-2 text-sm font-semibold tracking-wider uppercase text-gray-900 hover:text-brand">
                    {{ $link['label'] }}
                </a>
            @endforeach
            @auth
                <a href="{{ route('profile.show') }}" class="block py-2 text-sm font-semibold tracking-wider uppercase text-gray-900 hover:text-brand">
                    PROFIL
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-sm font-semibold tracking-wider uppercase text-gray-900 hover:text-brand">
                        LOGOUT
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-sm font-semibold tracking-wider uppercase text-gray-900 hover:text-brand">
                    LOGIN
                </a>
                <a href="{{ route('register') }}" class="block py-2 text-sm font-semibold tracking-wider uppercase text-gray-900 hover:text-brand">
                    REGISTER
                </a>
            @endauth
        </div>
    </div>
</nav>
