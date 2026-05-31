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
        🔒 Bảo mật dữ liệu cá nhân
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

    @php
        $collections = [
            [
                'name'  => 'Hoa khai trương',
                'slug'  => 'Hoa khai trương',
                'desc'  => 'Rực rỡ và hoành tráng, chúc mừng khởi đầu thịnh vượng.',
                'image' => 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'  => 'Hoa sinh nhật',
                'slug'  => 'Hoa sinh nhật',
                'desc'  => 'Tươi vui và rạng rỡ, gửi trọn lời chúc ngày đặc biệt.',
                'image' => 'https://images.unsplash.com/photo-1487530811176-3780de880c2d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'  => 'Hoa cưới',
                'slug'  => 'Hoa cưới',
                'desc'  => 'Thanh lịch và lãng mạn, tô điểm ngày trọng đại.',
                'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'  => 'Hoa chia buồn',
                'slug'  => 'Hoa chia buồn',
                'desc'  => 'Trang trọng và tinh tế, gửi lời chia sẻ chân thành.',
                'image' => 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=800&q=80',
            ],
        ];
    @endphp

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($collections as $collection)
            @php
                $category = \App\Models\Category::where('name', $collection['slug'])->first();
                $categoryLink = $category
                    ? route('products.index', ['category' => $category->id])
                    : route('products.index');
            @endphp
            <a href="{{ $categoryLink }}" class="group relative block overflow-hidden rounded-3xl border border-white/10 bg-lux-card shadow-lg transition-all duration-500 hover:-translate-y-2 hover:border-lux-gold/30 hover:shadow-2xl">
                <img src="{{ $collection['image'] }}" alt="{{ $collection['name'] }}" class="h-56 w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-5 text-lux-text">
                    <p class="text-xs uppercase tracking-[0.2em] text-lux-gold/70">Danh mục</p>
                    <h3 class="mt-1.5 font-serif text-2xl font-semibold transition duration-300 group-hover:text-lux-gold">{{ $collection['name'] }}</h3>
                    <p class="mt-1.5 text-sm text-lux-text/70">{{ $collection['desc'] }}</p>
                </div>
            </a>
        @endforeach
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

{{-- Premium Contact/Map Section --}}
<section class="mt-16 mb-8 animate-fade-in-up">
    <div class="rounded-[2.5rem] border border-white/10 bg-lux-card/70 p-8 shadow-2xl sm:p-12">
        <div class="grid gap-10 md:grid-cols-2 md:items-center">
            
            {{-- Column 1: Store Information --}}
            <div class="space-y-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lux-gold/80">Liên hệ</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold text-lux-text sm:text-4xl">Ghé Thăm Tuki Fresh Flower</h2>
                </div>
                
                <p class="text-lux-text/70 leading-relaxed">
                    Đến với cửa hàng của chúng tôi để trực tiếp cảm nhận vẻ đẹp tinh tế của từng đóa hoa tươi và nhận được sự tư vấn tận tình nhất cho nhu cầu của bạn.
                </p>

                <div class="space-y-4 rounded-2xl border border-white/5 bg-lux-bg/50 p-6 shadow-inner">
                    <div class="flex items-start gap-4">
                        <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-lux-gold/10 text-lux-gold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-lux-text/60">Địa chỉ cửa hàng</p>
                            <p class="mt-1 font-semibold text-lux-gold">140 Lê Trọng Tấn, Tây Thạnh, Hồ Chí Minh, Việt Nam</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-lux-gold/10 text-lux-gold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-lux-text/60">Điện thoại</p>
                            <p class="mt-1 font-semibold text-lux-gold">0866 384 257</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-lux-gold/10 text-lux-gold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-lux-text/60">Giờ mở cửa</p>
                            <p class="mt-1 font-semibold text-lux-gold">08:00 - 21:00 (Mỗi ngày)</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Column 2: Google Maps Iframe Wrapper --}}
            <div class="h-full w-full rounded-2xl overflow-hidden border border-white/10 bg-lux-bg shadow-inner relative group">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4245.645453409951!2d106.62625947538994!3d10.806920289343747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27ea41e05%3A0xfa77697a39f13ab0!2zMTQwIEzDqiBUcuG7jW5nIFThuqVuLCBUw6J5IFRo4bqhbmgsIEjhu5MgQ2jDrSBNaW5oIDcwMDAwMCwgVmnhu4d0IE5hbQ!5e1!3m2!1svi!2s!4v1780243504623!5m2!1svi!2s" 
                    class="w-full h-full min-h-[350px] md:h-[400px] grayscale opacity-75 contrast-125 transition-all duration-500 hover:grayscale-0 hover:opacity-100"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    sandbox="allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-top-navigation-by-user-activation">
                </iframe>
                {{-- Interactive hint overlay for non-hover devices or initial state --}}
                <div class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/20 opacity-100 transition-opacity duration-500 group-hover:opacity-0">
                    <span class="rounded-full bg-lux-bg/80 px-4 py-2 text-sm font-medium text-lux-gold backdrop-blur-md shadow-lg border border-lux-gold/20">Chạm để xem bản đồ</span>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
