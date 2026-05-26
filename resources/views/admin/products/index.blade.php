@extends('layouts.app')

@section('content')
<section class="rounded-3xl border border-white/5 bg-lux-card p-5 shadow-sm sm:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-lux-gold">Quản lý sản phẩm</h1>
            <p class="mt-1 text-sm text-lux-text/60">Quản lý chất lượng, giá cả và hiển thị sản phẩm.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="rounded-xl bg-lux-gold px-4 py-2 text-sm font-semibold text-lux-bg shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">+ Thêm sản phẩm</a>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($products as $product)
            @php
                $inStock = ($product->status ?? 'active') === 'active';
            @endphp
            <article class="rounded-2xl border border-white/5 bg-lux-bg p-4 shadow-sm transition hover:border-lux-gold/20 hover:shadow-xl sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/120x90?text=Flower' }}" alt="{{ $product->name }}" class="h-16 w-24 rounded-xl object-cover">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-lg font-semibold text-lux-text">{{ $product->name }}</h2>
                                @if ($inStock)
                                    <span class="rounded-full bg-emerald-900/60 px-2.5 py-1 text-xs font-semibold text-lux-gold">Còn hàng</span>
                                @else
                                    <span class="rounded-full bg-white/10 px-2.5 py-1 text-xs font-semibold text-lux-text/60">Hết hàng</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-lux-text/60">{{ $product->category->name ?? '-' }} • <span class="text-lux-gold font-semibold">{{ number_format($product->price, 0, ',', '.') }} VND</span></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-lux-gold/40 px-3 py-2 text-xs font-semibold text-lux-gold transition hover:bg-lux-gold/10">Sửa</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-500/40 px-3 py-2 text-xs font-semibold text-red-400 transition hover:bg-red-500/10">Xóa</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-dashed border-white/10 bg-lux-bg p-8 text-center text-sm text-lux-text/50">Chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
</section>
@endsection
