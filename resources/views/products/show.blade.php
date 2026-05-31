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

            <div class="grid grid-cols-4 gap-3">
                {{-- Main Image as First Thumbnail --}}
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/900x700?text=Fresh+Flower' }}" alt="{{ $product->name }} main" class="gallery-thumbnail w-full h-16 rounded-xl overflow-hidden border border-lux-gold cursor-pointer object-cover transition duration-300">

                @if ($product->images->isNotEmpty())
                    @foreach ($product->images as $galleryImage)
                        @php
                            $galleryPath = $galleryImage->image_path;
                        @endphp
                        @if ($galleryPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($galleryPath))
                            <img src="{{ asset('storage/' . $galleryPath) }}" alt="{{ $product->name }} gallery" class="gallery-thumbnail w-full h-16 rounded-xl overflow-hidden border border-white/10 cursor-pointer object-cover transition duration-300 hover:border-lux-gold/50">
                        @endif
                    @endforeach
                @endif
            </div>
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

{{-- Reviews Section --}}
<section class="mt-12 animate-fade-in-up">
    <div class="rounded-3xl border border-white/5 bg-lux-card p-6 shadow-xl sm:p-8">
        <h2 class="font-serif text-2xl font-semibold text-lux-text mb-6 border-b border-white/10 pb-4">Đánh giá sản phẩm</h2>

        {{-- Existing Reviews --}}
        <div class="space-y-6 mb-10">
            @forelse ($product->reviews()->with('user')->latest()->get() as $review)
                <div class="flex gap-4">
                    <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&color=E5C07B&background=111F1A' }}" alt="{{ $review->user->name }}" class="h-12 w-12 rounded-full object-cover border border-lux-gold/30">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium text-lux-text">{{ $review->user->name }}</h3>
                            <span class="text-xs text-lux-text/50">{{ $review->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1 mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-lux-gold' : 'text-lux-text/20' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>
                        <p class="mt-2 text-sm text-lux-text/80 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="text-lux-text/50 text-sm italic">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên!</p>
            @endforelse
        </div>

        {{-- Add Review Form --}}
        @auth
            <div class="rounded-2xl border border-white/5 bg-lux-bg p-5">
                <h3 class="font-medium text-lux-gold mb-4">Viết đánh giá của bạn</h3>
                <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm text-lux-text/70 mb-2">Đánh giá (1-5 sao)</label>
                        <div class="flex items-center gap-1" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg data-value="{{ $i }}" class="star h-8 w-8 cursor-pointer text-lux-text/20 transition hover:text-lux-gold/70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="0" required>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="comment" class="block text-sm text-lux-text/70 mb-2">Nhận xét</label>
                        <textarea name="comment" id="comment" rows="3" required class="w-full rounded-xl border border-white/10 bg-lux-card px-4 py-3 text-sm text-lux-text focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="rounded-lg bg-lux-gold px-6 py-2.5 text-sm font-semibold text-lux-bg shadow-md transition hover:shadow-lg hover:shadow-lux-gold/20 active:scale-[0.98]">
                        Gửi đánh giá
                    </button>
                </form>
            </div>
        @else
            <div class="rounded-2xl border border-white/5 bg-lux-bg p-5 text-center">
                <p class="text-lux-text/70 mb-3 text-sm">Vui lòng đăng nhập để viết đánh giá.</p>
                <a href="{{ route('login') }}" class="inline-block rounded-lg border border-lux-gold px-5 py-2 text-sm font-semibold text-lux-gold transition hover:bg-lux-gold/10">Đăng nhập ngay</a>
            </div>
        @endauth
    </div>
</section>

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
                thumbnail.classList.remove('border-lux-gold');
                thumbnail.classList.add('border-white/10');
            });
            active.classList.remove('border-white/10');
            active.classList.add('border-lux-gold');
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
                
                // Smooth transition
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.setAttribute('src', nextSrc);
                    mainImage.style.opacity = '1';
                }, 150);

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

        // Star Rating Logic
        const stars = Array.from(document.querySelectorAll('.star'));
        const ratingInput = document.getElementById('rating-value');
        let currentRating = 0;

        if (stars.length > 0 && ratingInput) {
            const updateStars = (rating) => {
                stars.forEach((star) => {
                    const value = parseInt(star.getAttribute('data-value'), 10);
                    if (value <= rating) {
                        star.classList.add('text-lux-gold');
                        star.classList.remove('text-lux-text/20');
                    } else {
                        star.classList.remove('text-lux-gold');
                        star.classList.add('text-lux-text/20');
                    }
                });
            };

            stars.forEach((star) => {
                star.addEventListener('mouseover', () => {
                    updateStars(parseInt(star.getAttribute('data-value'), 10));
                });

                star.addEventListener('mouseout', () => {
                    updateStars(currentRating);
                });

                star.addEventListener('click', () => {
                    currentRating = parseInt(star.getAttribute('data-value'), 10);
                    ratingInput.value = currentRating;
                    updateStars(currentRating);
                });
            });
        }
    })();
</script>
@endsection
