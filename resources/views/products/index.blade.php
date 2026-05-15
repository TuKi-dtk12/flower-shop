@extends('layouts.app')

@section('content')
<section class="animate-fade-in-up">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-serif text-4xl font-semibold text-gray-900">Flower Catalog</h1>
            <p class="mt-1 text-sm text-gray-600">Minimal luxury bouquets for every mood and celebration.</p>
        </div>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-rose-600 transition hover:text-rose-700">Back to home</a>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[260px,1fr]">
        <aside class="lux-glass rounded-3xl p-6 lg:sticky lg:top-24 lg:h-fit">
            <h2 class="font-serif text-2xl font-semibold text-gray-900">Filter by Category</h2>
            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-gray-500">Quick selection</p>

            <div class="mt-4 space-y-2">
                <a href="{{ route('products.index') }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ empty($categoryId) ? 'bg-organic-coral text-white shadow-sm' : 'border border-rose-200 bg-white/70 text-rose-700 hover:bg-rose-50' }}">All Flowers</a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block rounded-xl px-4 py-2 text-sm font-semibold transition {{ (int) $categoryId === (int) $category->id ? 'bg-organic-crimson text-white shadow-sm' : 'border border-emerald-200 bg-white/70 text-emerald-700 hover:bg-emerald-50' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </aside>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                @php
                    $isOutOfStock = isset($product->status) && $product->status !== 'active';
                @endphp

                <article class="group overflow-hidden rounded-3xl border border-white/70 bg-white/85 shadow-lg ring-1 ring-rose-100/60 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <a href="{{ route('products.show', $product) }}" class="relative block overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-organic-crimson shadow-sm">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                    </a>

                    <div class="p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">{{ $product->category->name ?? 'Flower' }}</p>
                            @if ($isOutOfStock)
                                <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-600">Out of Stock</span>
                            @else
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">In Stock</span>
                            @endif
                        </div>

                        <h2 class="mt-2 text-lg font-semibold text-gray-900">{{ $product->name }}</h2>

                        <div class="mt-4 flex items-center justify-between gap-2">
                            <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-gray-700 transition hover:text-gray-900">View details</a>

                            @if ($isOutOfStock)
                                <button type="button" disabled class="cursor-not-allowed rounded-lg bg-gray-300 px-3 py-2 text-xs font-semibold text-white">Out of stock</button>
                            @elseif (auth()->check())
                                <form method="POST" action="{{ route('cart.store') }}" class="translate-y-1 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="rounded-lg bg-gradient-to-r from-organic-coral to-organic-crimson px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:shadow-xl">
                                        Add to cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="translate-y-1 opacity-0 text-xs font-semibold text-organic-crimson transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">Login to buy</a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-500">No products found.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</section>
@endsection
