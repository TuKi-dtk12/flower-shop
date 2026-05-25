@extends('layouts.app')

@section('content')
<article class="animate-fade-in-up overflow-hidden rounded-3xl border border-white/5 bg-lux-card shadow-2xl">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        {{-- Image Gallery --}}
        <div class="space-y-3 p-5">
            <a id="main-image-link" href="#" class="group relative block overflow-hidden rounded-2xl">
                <img id="main-image" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/900x700?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-80 w-full rounded-2xl object-cover transition duration-500 group-hover:scale-105 sm:h-96">
                {{-- Zoom hint --}}
                <span class="absolute bottom-3 right-3 flex items-center gap-1.5 rounded-full bg-lux-bg/70 px-3 py-1.5 text-xs font-medium text-lux-text/70 opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/>
                    </svg>
                    Phóng to
                </span>
            </a>

            @if ($product->images->isNotEmpty())
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($product->images as $galleryImage)
                        @php
                            $galleryPath = $galleryImage->image_path;
                        @endphp
                        @if ($galleryPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($galleryPath))
                            <img src="{{ asset('storage/' . $galleryPath) }}" alt="{{ $product->name }} gallery" class="gallery-thumbnail h-24 w-full cursor-pointer rounded-xl border-2 border-transparent object-cover transition duration-300 hover:border-lux-gold/50">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="flex flex-col justify-center p-6 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lux-gold/70">{{ $product->category->name ?? 'Hoa' }}</p>
            <h1 class="mt-2 font-serif text-4xl font-semibold text-lux-text">{{ $product->name }}</h1>

            <div class="mt-4 flex items-baseline gap-2">
                <p class="font-serif text-3xl font-bold text-lux-gold">{{ number_format($product->price, 0, ',', '.') }}</p>
                <span class="text-sm font-medium text-lux-gold/60">VND</span>
            </div>

            <div class="mt-5 h-px bg-gradient-to-r from-lux-gold/20 via-lux-gold/10 to-transparent"></div>

            <p class="mt-5 leading-relaxed text-lux-text/70">{{ $product->description ?: 'Bó hoa được thiết kế tinh tế cho những khoảnh khắc ý nghĩa.' }}</p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" min="1" value="1" class="w-20 rounded-lg border border-white/10 bg-lux-bg px-3 py-2.5 text-sm text-lux-text text-center focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                        <button type="submit" class="rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg shadow-lg shadow-lux-gold/20 transition duration-300 hover:shadow-xl hover:shadow-lux-gold/30 active:scale-[0.98]">
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg shadow-lg transition hover:shadow-xl">Đăng nhập để mua</a>
                @endauth

                <a href="{{ route('products.index') }}" class="rounded-lg border border-white/10 px-5 py-2.5 text-sm font-semibold text-lux-text/70 transition hover:bg-white/5 hover:text-lux-gold">← Quay lại danh sách</a>
            </div>
        </div>
    </div>
</article>

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4 backdrop-blur-sm">
    <button id="lightbox-close" type="button" class="absolute right-5 top-5 rounded-full border border-lux-gold/30 bg-lux-card/80 px-4 py-1.5 text-sm font-semibold text-lux-gold transition hover:bg-lux-gold/10">
        Đóng ✕
    </button>
    <img id="lightbox-image" src="" alt="{{ $product->name }}" class="max-h-full max-w-full rounded-xl object-contain shadow-2xl">
</div>

<script>
    (function () {
        const mainImage = document.getElementById('main-image');
        const mainImageLink = document.getElementById('main-image-link');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxClose = document.getElementById('lightbox-close');
        const thumbnails = Array.from(document.querySelectorAll('.gallery-thumbnail'));

        if (!mainImage || !mainImageLink || !lightbox || !lightboxImage || !lightboxClose) {
            return;
        }

        const setActiveThumbnail = (active) => {
            thumbnails.forEach((thumbnail) => {
                thumbnail.classList.remove('border-lux-gold', 'ring-2', 'ring-lux-gold/30');
            });
            active.classList.add('border-lux-gold', 'ring-2', 'ring-lux-gold/30');
        };

        if (thumbnails.length > 0) {
            setActiveThumbnail(thumbnails[0]);
        }

        thumbnails.forEach((thumbnail) => {
            thumbnail.addEventListener('click', () => {
                const nextSrc = thumbnail.getAttribute('src');
                if (!nextSrc) {
                    return;
                }
                mainImage.setAttribute('src', nextSrc);
                setActiveThumbnail(thumbnail);
            });
        });

        const openLightbox = () => {
            const src = mainImage.getAttribute('src');
            if (!src) {
                return;
            }
            lightboxImage.setAttribute('src', src);
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
        };

        const closeLightbox = () => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            lightboxImage.setAttribute('src', '');
        };

        mainImageLink.addEventListener('click', (event) => {
            event.preventDefault();
            openLightbox();
        });

        lightboxClose.addEventListener('click', closeLightbox);

        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                closeLightbox();
            }
        });
    })();
</script>
@endsection
