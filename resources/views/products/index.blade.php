@extends('layouts.app')

@section('content')
<section class="animate-fade-in-up">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-serif text-4xl font-semibold text-lux-text">Danh mục hoa</h1>
            <p class="mt-1 text-sm text-lux-text/70">Bó hoa tinh tế cho mọi cảm xúc và dịp đặc biệt.</p>
        </div>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-lux-gold transition hover:text-lux-gold/80">Quay lại trang chủ</a>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[260px,1fr]">
        <aside class="space-y-5 lg:sticky lg:top-24 lg:h-fit">
            {{-- 🔍 Search Box --}}
            <div class="rounded-3xl bg-[#111F1A] p-6">
                <h2 class="font-serif text-lg font-semibold text-[#E2E8F0]">Tìm kiếm</h2>
                <p class="mt-0.5 text-xs uppercase tracking-[0.16em] text-[#E2E8F0]/70">Nhập tên mẫu hoa</p>

                <form method="GET" action="{{ route('products.index') }}" class="mt-4" id="search-form">
                    @if($categoryId)
                        <input type="hidden" name="category" value="{{ $categoryId }}">
                    @endif

                    <div class="group relative">
                        {{-- Magnifying glass icon --}}
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <svg class="h-4 w-4 text-[#E5C07B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>

                        <input
                            type="text"
                            name="search"
                            id="product-search-input"
                            value="{{ $search ?? '' }}"
                            placeholder="Tìm kiếm mẫu hoa..."
                            autocomplete="off"
                            class="w-full rounded-xl border border-white/10 bg-[#08100D] py-2.5 pl-10 pr-10 text-sm text-[#E2E8F0] placeholder-[#E2E8F0]/40 shadow-inner transition duration-300 focus:border-[#E5C07B] focus:outline-none focus:ring-1 focus:ring-[#E5C07B]/40"
                        >

                        {{-- Clear button (visible when search has value) --}}
                        @if(!empty($search))
                            <a href="{{ route('products.index', $categoryId ? ['category' => $categoryId] : []) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#E2E8F0]/50 transition hover:text-[#E5C07B]" title="Xóa tìm kiếm">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <button type="submit" id="search-submit-btn" class="mt-3 w-full rounded-xl bg-[#E5C07B]/10 px-4 py-2 text-sm font-semibold text-[#E5C07B] shadow-sm transition duration-300 hover:bg-[#E5C07B]/20 hover:shadow-md active:scale-[0.98]">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                            Tìm
                        </span>
                    </button>
                </form>

                {{-- Active search indicator --}}
                @if(!empty($search))
                    <div class="mt-3 flex items-center gap-2 rounded-lg bg-[#E5C07B]/10 px-3 py-2 text-xs text-[#E2E8F0]/80">
                        <svg class="h-3.5 w-3.5 shrink-0 text-[#E5C07B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <span>Kết quả cho: <strong class="text-[#E5C07B]">{{ $search }}</strong></span>
                    </div>
                @endif
            </div>

            {{-- 🏷️ Category Filter --}}
            <div class="rounded-3xl bg-[#111F1A] p-6">
                <h2 class="font-serif text-2xl font-semibold text-[#E2E8F0]">Lọc theo danh mục</h2>
                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#E2E8F0]/70">Chọn nhanh</p>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('products.index', !empty($search) ? ['search' => $search] : []) }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ empty($categoryId) ? 'bg-[#E5C07B] text-[#08100D] shadow-sm' : 'border border-white/10 bg-[#111F1A] text-[#E2E8F0] hover:border-[#E5C07B]/50 hover:text-[#E5C07B]' }}">Tất cả hoa</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('products.index', array_filter(['category' => $category->id, 'search' => $search ?? null])) }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ (int) $categoryId === (int) $category->id ? 'bg-[#E5C07B] text-[#08100D] shadow-sm' : 'border border-white/10 bg-[#111F1A] text-[#E2E8F0] hover:border-[#E5C07B]/50 hover:text-[#E5C07B]' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                @php
                    $isOutOfStock = isset($product->status) && $product->status !== 'active';
                @endphp

                <article class="group overflow-hidden rounded-3xl border border-white/5 bg-[#111F1A] shadow-lg transition duration-500 hover:-translate-y-2 hover:border-[#E5C07B]/40 hover:shadow-[0_20px_40px_-20px_rgba(229,192,123,0.45)]">
                    <a href="{{ route('products.show', $product) }}" class="relative block overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Tuki+Fresh+Flower' }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute left-3 top-3 rounded-full bg-[#08100D]/80 px-3 py-1 text-xs font-semibold text-[#E5C07B] shadow-sm">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                    </a>

                    <div class="p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-[#E2E8F0]/70">{{ $product->category->name ?? 'Hoa' }}</p>
                            @if ($isOutOfStock)
                                <span class="rounded-full bg-[#08100D] px-3 py-1 text-xs font-semibold text-[#E2E8F0]/60">Hết hàng</span>
                            @else
                                <span class="rounded-full bg-emerald-800/50 px-3 py-1 text-xs font-semibold text-white">Còn hàng</span>
                            @endif
                        </div>

                        <h2 class="mt-2 text-lg font-semibold text-white">{{ $product->name }}</h2>

                        <div class="mt-4 flex items-center justify-between gap-2">
                            <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-[#E2E8F0]/80 transition hover:text-[#E5C07B]">Xem chi tiết</a>

                            @if ($isOutOfStock)
                                <button type="button" disabled class="cursor-not-allowed rounded-lg bg-white/10 px-3 py-2 text-xs font-semibold text-[#E2E8F0]/60">Hết hàng</button>
                            @elseif (auth()->check())
                                <form method="POST" action="{{ route('cart.store') }}" class="translate-y-1 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="rounded-lg bg-[#E5C07B] px-3 py-2 text-xs font-semibold text-[#08100D] shadow-sm transition hover:shadow-xl">
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="translate-y-1 opacity-0 text-xs font-semibold text-[#E5C07B] transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">Đăng nhập để mua</a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-white/20 bg-lux-card p-8 text-center">
                    @if(!empty($search))
                        <svg class="mx-auto h-12 w-12 text-lux-text/30" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                        <p class="mt-3 text-sm text-lux-text/70">Không tìm thấy mẫu hoa nào cho "<strong class="text-lux-gold">{{ $search }}</strong>"</p>
                        <a href="{{ route('products.index', $categoryId ? ['category' => $categoryId] : []) }}" class="mt-3 inline-block text-sm font-semibold text-lux-gold transition hover:text-lux-gold/80">Xóa tìm kiếm</a>
                    @else
                        <p class="text-lux-text/70">Chưa có sản phẩm nào.</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</section>
@endsection
