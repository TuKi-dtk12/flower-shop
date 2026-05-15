@extends('layouts.app')

@section('content')
<article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="space-y-3 p-5">
            <a id="main-image-link" href="#" class="block">
                <img id="main-image" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/900x700?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-80 w-full rounded-2xl object-cover sm:h-96">
            </a>

            @if ($product->images->isNotEmpty())
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($product->images as $galleryImage)
                        @php
                            $galleryPath = $galleryImage->image_path;
                        @endphp
                        @if ($galleryPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($galleryPath))
                            <img src="{{ asset('storage/' . $galleryPath) }}" alt="{{ $product->name }} gallery" class="gallery-thumbnail h-24 w-full cursor-pointer rounded-xl border border-transparent object-cover transition hover:border-rose-300">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="p-6 sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">{{ $product->category->name ?? 'Flower' }}</p>
            <h1 class="mt-2 font-['Playfair_Display'] text-4xl font-semibold text-gray-900">{{ $product->name }}</h1>
            <p class="mt-3 text-2xl font-semibold text-rose-600">{{ number_format($product->price, 0, ',', '.') }} VND</p>

            <p class="mt-5 leading-relaxed text-gray-600">{{ $product->description ?: 'Freshly designed floral arrangement for meaningful moments.' }}</p>

            <div class="mt-6 flex flex-wrap gap-3">
                @auth
                    <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" min="1" value="1" class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <button type="submit" class="rounded-lg bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">Add to Cart</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">Login to purchase</a>
                @endauth

                <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Back to list</a>
            </div>
        </div>
    </div>
</article>

<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4">
    <button id="lightbox-close" type="button" class="absolute right-5 top-5 rounded-full border border-white/30 bg-white/10 px-3 py-1 text-sm font-semibold text-white transition hover:bg-white/20">
        Close
    </button>
    <img id="lightbox-image" src="" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
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
                thumbnail.classList.remove('border-rose-400', 'ring-2', 'ring-rose-200');
            });
            active.classList.add('border-rose-400', 'ring-2', 'ring-rose-200');
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
