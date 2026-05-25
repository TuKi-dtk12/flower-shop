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
        <aside class="lux-glass rounded-3xl p-6 lg:sticky lg:top-24 lg:h-fit">
            <h2 class="font-serif text-2xl font-semibold text-lux-text">Lọc theo danh mục</h2>
            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-lux-text/60">Chọn nhanh</p>

            <div class="mt-4 space-y-2">
                <a href="{{ route('products.index') }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ empty($categoryId) ? 'bg-lux-gold text-lux-bg shadow-sm' : 'border border-white/10 bg-lux-card text-lux-text/80 hover:border-lux-gold/40 hover:text-lux-gold' }}">Tất cả hoa</a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ (int) $categoryId === (int) $category->id ? 'bg-lux-gold text-lux-bg shadow-sm' : 'border border-white/10 bg-lux-card text-lux-text/80 hover:border-lux-gold/40 hover:text-lux-gold' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </aside>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                @php
                    $isOutOfStock = isset($product->status) && $product->status !== 'active';
                @endphp

                <article class="group overflow-hidden rounded-3xl border border-white/5 bg-lux-card shadow-lg transition duration-500 hover:-translate-y-2 hover:border-lux-gold/30 hover:shadow-2xl">
                    <a href="{{ route('products.show', $product) }}" class="relative block overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Tuki+Fresh+Flower' }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute left-3 top-3 rounded-full bg-lux-bg/80 px-3 py-1 text-xs font-semibold text-lux-gold shadow-sm">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                    </a>

                    <div class="p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-lux-text/70">{{ $product->category->name ?? 'Hoa' }}</p>
                            @if ($isOutOfStock)
                                <span class="rounded-full bg-lux-bg px-3 py-1 text-xs font-semibold text-lux-text/60">Hết hàng</span>
                            @else
                                <span class="rounded-full bg-emerald-900/60 px-3 py-1 text-xs font-semibold text-lux-gold">Còn hàng</span>
                            @endif
                        </div>

                        <h2 class="mt-2 text-lg font-semibold text-lux-text">{{ $product->name }}</h2>

                        <div class="mt-4 flex items-center justify-between gap-2">
                            <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-lux-text/80 transition hover:text-lux-gold">Xem chi tiết</a>

                            @if ($isOutOfStock)
                                <button type="button" disabled class="cursor-not-allowed rounded-lg bg-white/10 px-3 py-2 text-xs font-semibold text-lux-text/60">Hết hàng</button>
                            @elseif (auth()->check())
                                <form method="POST" action="{{ route('cart.store') }}" class="translate-y-1 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="rounded-lg bg-lux-gold px-3 py-2 text-xs font-semibold text-lux-bg shadow-sm transition hover:shadow-xl">
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="translate-y-1 opacity-0 text-xs font-semibold text-lux-gold transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">Đăng nhập để mua</a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-xl border border-dashed border-white/20 bg-lux-card p-6 text-center text-lux-text/70">Chưa có sản phẩm nào.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</section>
@endsection
