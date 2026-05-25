@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-serif text-3xl font-semibold text-lux-gold">Giỏ hàng</h1>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-lux-gold/80 transition hover:text-lux-gold">← Tiếp tục mua sắm</a>
    </div>

    @if (empty($cart))
        <div class="mt-6 rounded-2xl border border-dashed border-white/10 bg-lux-bg p-8 text-center text-lux-text/50">Giỏ hàng đang trống.</div>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($cart as $item)
                <div class="flex flex-col gap-4 rounded-2xl border border-white/5 bg-lux-bg p-4 transition hover:border-lux-gold/20 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/180x140?text=Flower' }}" alt="{{ $item['name'] }}" class="h-20 w-24 rounded-lg object-cover">
                        <div>
                            <h2 class="text-base font-semibold text-lux-text">{{ $item['name'] }}</h2>
                            <p class="text-sm font-semibold text-lux-gold">{{ number_format($item['price'], 0, ',', '.') }} VND</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="w-20 rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                            <button type="submit" class="rounded-lg border border-lux-gold/40 px-3 py-2 text-sm font-semibold text-lux-gold transition hover:bg-lux-gold/10">Cập nhật</button>
                        </form>

                        <form method="POST" action="{{ route('cart.destroy', $item['product_id']) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-500/40 px-3 py-2 text-sm font-semibold text-red-400 transition hover:bg-red-500/10">Xóa</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-2xl bg-lux-gold/10 p-5">
            <div class="flex items-center justify-between text-lg font-semibold">
                <span class="text-lux-text">Tổng cộng</span>
                <span class="text-lux-gold">{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="mt-4 inline-flex rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg shadow-lg transition hover:shadow-xl active:scale-[0.98]">Tiến hành thanh toán</a>
        </div>
    @endif
</div>
@endsection
