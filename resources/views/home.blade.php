@extends('layouts.app')

@section('content')
@php
    $bentoCategories = $featuredProducts
        ->pluck('category.name')
        ->filter()
        ->unique()
        ->take(5)
        ->values();

    $heroProduct = $featuredProducts->first();

    $categoryImages = [
        'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1468327768560-75b778cbb551?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1487070183336-b863922373d4?auto=format&fit=crop&w=1200&q=80',
    ];
@endphp

<section class="relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-lux-card/70 px-8 py-16 shadow-sm sm:px-12">
    <div class="absolute -top-16 right-8 hidden h-56 w-56 rounded-full bg-lux-gold/10 blur-3xl lg:block"></div>
    <div class="absolute -bottom-16 left-10 hidden h-56 w-56 rounded-full bg-emerald-500/10 blur-3xl lg:block"></div>

    <div class="relative grid gap-12 lg:grid-cols-[1.15fr,0.85fr] lg:items-center">
        <div>
            <p class="inline-flex rounded-full border border-lux-gold/40 bg-lux-bg/80 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-lux-gold">
                Tuki Fresh Flower
            </p>
            <h1 class="mt-5 max-w-3xl font-serif text-5xl font-semibold leading-tight text-lux-text sm:text-6xl">
                Mỗi bó hoa là một tuyên ngôn tinh tế cho những khoảnh khắc đáng nhớ
            </h1>
            <p class="mt-5 max-w-2xl text-base leading-relaxed text-lux-text/70 sm:text-lg">
                Chúng tôi chọn lọc hoa theo mùa, phối sắc sang trọng và gói quà chỉn chu để bạn trao đi sự trân trọng đúng lúc.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}" class="rounded-xl bg-lux-gold px-6 py-3 text-sm font-semibold text-lux-bg shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                    Mua sắm ngay
                </a>
                @auth
                    <a href="{{ route('cart.index') }}" class="rounded-xl border border-lux-gold/40 bg-lux-bg/80 px-6 py-3 text-sm font-semibold text-lux-gold transition hover:-translate-y-0.5 hover:bg-lux-gold/10">
                        Mở giỏ hàng
                    </a>
                @endauth
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-lux-card/90 p-5 shadow-xl backdrop-blur">
            @if ($heroProduct)
                <a href="{{ route('products.show', $heroProduct) }}" class="group block overflow-hidden rounded-2xl">
                    <img src="{{ $heroProduct->image ? asset('storage/' . $heroProduct->image) : 'https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $heroProduct->name }}" class="h-72 w-full object-cover transition duration-500 group-hover:scale-105">
                </a>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs uppercase tracking-[0.2em] text-lux-gold/80">Nổi bật</p>
                        <span class="rounded-full bg-emerald-900/60 px-3 py-1 text-xs font-semibold text-lux-gold">Còn hàng</span>
                    </div>
                    <h2 class="font-serif text-2xl font-semibold text-lux-text">{{ $heroProduct->name }}</h2>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-lux-text/60">Gợi ý sang trọng</span>
                        <span class="rounded-full bg-lux-bg/80 px-4 py-2 text-sm font-semibold text-lux-gold shadow-sm">{{ number_format($heroProduct->price, 0, ',', '.') }} VND</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-2xl border border-white/10 bg-lux-card p-5 text-sm font-medium text-lux-text/80 shadow-sm">
        🚚 Giao hoa hỏa tốc 2h
    </div>
    <div class="rounded-2xl border border-white/10 bg-lux-card p-5 text-sm font-medium text-lux-text/80 shadow-sm">
        🌹 Cam kết hoa tươi mỗi ngày
    </div>
    <div class="rounded-2xl border border-white/10 bg-lux-card p-5 text-sm font-medium text-lux-text/80 shadow-sm">
        🔒 Bảo mật thanh toán TLS 1.3
    </div>
    <div class="rounded-2xl border border-white/10 bg-lux-card p-5 text-sm font-medium text-lux-text/80 shadow-sm">
        📞 Hỗ trợ tận tâm 24/7
    </div>
</section>

<section class="mt-12">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-lux-gold/80">Bộ sưu tập chủ đạo</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold text-lux-text">Cảm hứng hoa dành cho mọi dịp quan trọng</h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-lux-gold transition hover:text-lux-gold/80">Khám phá tất cả</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($bentoCategories as $index => $categoryName)
            @php
                $imageUrl = $categoryImages[$index % count($categoryImages)];
            @endphp
            <article class="group relative overflow-hidden rounded-3xl border border-white/10 bg-[#111F1A] shadow-lg">
                <img src="{{ $imageUrl }}" alt="{{ $categoryName }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute bottom-0 left-0 right-0 p-5 text-lux-text">
                    <p class="text-xs uppercase tracking-[0.2em] text-lux-text/70">Danh mục</p>
                    <h3 class="mt-2 font-serif text-2xl font-semibold">{{ $categoryName }}</h3>
                    <p class="mt-2 text-sm text-lux-text/80">Bảng màu sang trọng, phù hợp tặng dịp quan trọng.</p>
                </div>
            </article>
        @empty
            <article class="rounded-3xl border border-dashed border-white/20 bg-lux-card p-6 text-sm text-lux-text/70 sm:col-span-2 lg:col-span-4">
                Điểm nhấn danh mục sẽ xuất hiện khi có sản phẩm.
            </article>
        @endforelse
    </div>
</section>

<section class="mt-12">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="font-serif text-3xl font-semibold text-lux-text">Sản phẩm nổi bật</h2>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-lux-gold transition hover:text-lux-gold/80">Xem tất cả sản phẩm</a>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($featuredProducts as $product)
            <article class="group overflow-hidden rounded-3xl border border-white/5 bg-[#111F1A] shadow-md transition-all duration-500 hover:-translate-y-2 hover:border-[#E5C07B]/40 hover:shadow-[0_20px_40px_-20px_rgba(229,192,123,0.45)]">
                <a href="{{ route('products.show', $product) }}" class="relative block overflow-hidden">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Tuki+Fresh+Flower' }}" alt="{{ $product->name }}" class="h-60 w-full object-cover transition duration-500 group-hover:scale-105">
                    <span class="absolute right-3 top-3 rounded-full bg-[#08100D]/80 px-3 py-1 text-xs font-semibold text-[#E5C07B] shadow-sm">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                </a>
                <div class="p-4">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-xs uppercase tracking-[0.2em] text-[#E2E8F0]/70">{{ $product->category->name ?? 'Flower' }}</p>
                        <span class="rounded-full bg-emerald-800/50 px-3 py-1 text-xs font-semibold text-white">Còn hàng</span>
                    </div>
                    <h3 class="mt-2 text-lg font-semibold text-white">{{ $product->name }}</h3>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-[#E2E8F0]/80 transition hover:text-[#E5C07B]">Xem chi tiết</a>
                        @auth
                            <form method="POST" action="{{ route('cart.store') }}" class="opacity-0 transition duration-300 group-hover:opacity-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="rounded-lg bg-[#E5C07B] px-3 py-2 text-xs font-semibold text-[#08100D] shadow-sm transition hover:-translate-y-0.5">
                                    Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="opacity-0 text-xs font-semibold text-[#E5C07B] transition duration-300 group-hover:opacity-100">Đăng nhập để mua</a>
                        @endauth
                    </div>
                </div>
            </article>
        @empty
            <p class="col-span-full rounded-xl border border-dashed border-white/20 bg-lux-card p-6 text-center text-lux-text/70">Chưa có sản phẩm nổi bật.</p>
        @endforelse
    </div>
</section>
@endsection
