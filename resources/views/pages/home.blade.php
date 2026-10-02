@extends('layouts.app')

@section('title', 'Home - Padang Rice')

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/ASET/nasipadang-hero.jpg') }}" alt="Padang Rice Hero" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 w-full">
        <div class="max-w-xl">
            <p class="text-white/80 text-xs md:text-sm font-semibold tracking-[0.3em] uppercase mb-3">AUTENTIK RUMAH MAKAN MINANG</p>
            <h1 class="hero-title text-5xl md:text-6xl lg:text-7xl text-white mb-6">PADANG<br>RICE</h1>
            <p class="text-white/80 text-sm md:text-base leading-relaxed mb-8">
                Sajian nasi padang otentik dengan resep turun-temurun dari ranah Minang. Setiap hidangan dibuat dari bahan pilihan, dimasak segar setiap hari, dan dihidangkan dengan cita rasa yang konsisten. Pengalaman kuliner Indonesia terbaik dalam satu piring.
            </p>
            <a href="/tentang" class="btn-dark">TENTANG KAMI</a>
        </div>
    </div>
</section>

{{-- Tentang Kami Section --}}
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="hero-title text-2xl md:text-3xl text-gray-900 mb-4">TENTANG KAMI</h2>
            <p class="text-sm text-gray-600 leading-relaxed">
                Padang Rice hadir sejak 2010 sebagai rumah makan Minang yang mengedepankan keaslian resep dan kualitas bahan. Kami percaya bahwa setiap hidangan adalah representasi dari budaya dan tradisi kuliner Indonesia yang kaya.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach([
                ['img' => 'assets/ASET/nasipadang-1.jpg', 'title' => 'RENDANG OTENTIK', 'desc' => 'Rendang daging sapi pilihan dimasak dengan 15 rempah tradisional selama 8 jam untuk mencapai tekstur empuk dan rasa mendalam.'],
                ['img' => 'assets/ASET/nasipadang-2.jpg', 'title' => 'AYAM POP', 'desc' => 'Ayam kampung direbus dengan daun singkong dan rempah pilihan, menghasilkan daging yang lembut dengan kuah kaldu yang gurih.'],
                ['img' => 'assets/ASET/nasipadang-3.jpg', 'title' => 'GULAI TUNJANG', 'desc' => 'Kikil sapi dimasak dalam kuah santan kental dengan campuran cabai merah dan rempah khas Minang.'],
                ['img' => 'assets/ASET/nasipadang-4.jpg', 'title' => 'DAUN SINGKONG', 'desc' => 'Daun singkong segar direbus dengan santan dan bumbu tradisional, menjadi pelengkap sempurna untuk setiap hidangan.'],
            ] as $item)
            <div class="bg-white shadow-lg overflow-hidden">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset($item['img']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-display font-bold text-sm mb-2">{{ $item['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        {{ $item['desc'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm text-gray-600 leading-relaxed">
                Kami berkomitmen untuk menjaga standar kualitas tertinggi dalam setiap hidangan. Dari pemilihan bahan baku segar hingga proses memasak yang teliti, setiap langkah dilakukan dengan penuh dedikasi untuk memberikan pengalaman kuliner terbaik bagi pelanggan kami.
            </p>
        </div>
    </div>
</section>

{{-- Berita Kami Section --}}
<section class="py-16 lg:py-24 bg-[#f5f5f5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="hero-title text-2xl md:text-3xl text-center text-gray-900 mb-10">BERITA KAMI</h2>

        @if($latestNews->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <div class="bg-white overflow-hidden shadow-md">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ asset($news->image ?? 'assets/ASET/nasipadang-hero.jpg') }}" alt="{{ $latestNews->first()->title }}" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-white p-6 lg:p-8 shadow-md flex flex-col justify-center">
                <h3 class="font-display font-bold text-lg md:text-xl uppercase mb-3">{{ $latestNews->first()->title }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                    {{ Str::limit(strip_tags($latestNews->first()->content), 220) }}
                </p>
                <p class="text-sm text-gray-600 leading-relaxed mb-6">
                    Pelajari lebih lanjut tentang keanekaragaman cita rasa Indonesia, rekomendasi menu, dan tantangan yang lahir dari hasrat Khan tradisional. Pelanggan hasrat terbuka untuk komunitas pelukan.
                </p>
                <a href="{{ route('news.show', $latestNews->first()->slug) }}" class="text-xs font-bold text-yellow-500 hover:text-yellow-600 uppercase tracking-wider flex items-center gap-1">
                    Baca selengkapnya <span class="text-lg">...</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestNews->skip(1)->take(4) as $news)
            <div class="bg-white overflow-hidden shadow-md">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ asset($news->image ?? 'assets/ASET/nasipadang-1.jpg') }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-display font-bold text-sm uppercase mb-2">{{ $news->title }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mb-3 line-clamp-3">
                        {{ Str::limit(strip_tags($news->content), 100) }}
                    </p>
                    <a href="{{ route('news.show', $news->slug) }}" class="text-xs font-bold text-yellow-500 hover:text-yellow-600 uppercase tracking-wider flex items-center gap-1">
                        Baca selengkapnya <span class="text-lg">...</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Galeri Kami Section --}}
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="hero-title text-2xl md:text-3xl text-center text-gray-900 mb-10">GALERI KAMI</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10">
            @foreach($galleries as $gallery)
            <div class="aspect-square overflow-hidden rounded-lg">
                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="/galeri" class="btn-dark">LIHAT LEBIH BANYAK</a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-sm', 'text-gray-900');
            navbar.classList.remove('bg-transparent', 'text-white');
        } else {
            navbar.classList.add('bg-transparent', 'text-white');
            navbar.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-sm', 'text-gray-900');
        }
    });
</script>
@endsection
