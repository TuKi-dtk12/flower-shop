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
@endphp

<section class="floral-hero-bg relative overflow-hidden rounded-[2rem] border border-white/70 p-8 shadow-sm animate-fade-in-up sm:p-12">
    <div class="absolute -top-14 right-10 hidden h-44 w-44 rounded-full bg-rose-200/60 blur-3xl lg:block"></div>
    <div class="absolute -bottom-16 left-10 hidden h-48 w-48 rounded-full bg-emerald-200/60 blur-3xl lg:block"></div>

    <div class="relative grid gap-10 lg:grid-cols-[1.15fr,0.85fr] lg:items-end">
        <div>
            <p class="inline-flex rounded-full border border-rose-200 bg-white/80 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-rose-600">
                Floral Luxury Collection
            </p>
            <h1 class="mt-5 max-w-3xl font-serif text-5xl font-semibold leading-tight text-floral-charcoal sm:text-6xl">
                Crafted Blooms For Life's Most Beautiful Moments
            </h1>
            <p class="mt-5 max-w-2xl text-base leading-relaxed text-gray-600 sm:text-lg">
                Discover premium stems arranged with a minimalist luxury touch. Every bouquet is curated to feel intentional, elegant, and memorable.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}" class="rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                    Shop Collection
                </a>
                @auth
                    <a href="{{ route('cart.index') }}" class="rounded-xl border border-emerald-300 bg-white/85 px-6 py-3 text-sm font-semibold text-emerald-700 transition hover:-translate-y-0.5 hover:bg-emerald-50">
                        Open Cart
                    </a>
                @endauth
            </div>
        </div>

        <div class="floral-glass floral-pattern-mobile rounded-3xl p-5 shadow-sm lg:p-6">
            @if ($heroProduct)
                <a href="{{ route('products.show', $heroProduct) }}" class="group block overflow-hidden rounded-2xl">
                    <img src="{{ $heroProduct->image ? asset('storage/' . $heroProduct->image) : 'https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $heroProduct->name }}" class="h-72 w-full object-cover transition duration-500 group-hover:scale-105">
                </a>
                <div class="mt-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">Featured</p>
                        <h2 class="mt-1 font-serif text-2xl font-semibold text-gray-900">{{ $heroProduct->name }}</h2>
                    </div>
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-rose-600 shadow-sm">{{ number_format($heroProduct->price, 0, ',', '.') }} VND</span>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <article class="floral-glass floral-pattern-mobile rounded-3xl p-6 shadow-sm animate-fade-in-up sm:col-span-2 lg:row-span-2">
        <h2 class="font-serif text-3xl font-semibold text-gray-900">Signature Arrangements</h2>
        <p class="mt-3 max-w-xl text-sm text-gray-600">A curated blend of seasonal petals and timeless tones, designed for weddings, gifting, and premium office spaces.</p>
        <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-xl border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-700 transition hover:shadow-sm">Explore now</a>
    </article>

    @forelse ($bentoCategories as $index => $categoryName)
        <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl animate-fade-in-up">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Category {{ $index + 1 }}</p>
            <h3 class="mt-3 font-serif text-2xl font-semibold text-gray-900">{{ $categoryName }}</h3>
            <p class="mt-2 text-sm text-gray-600">Refined floral selections with balanced tones and minimalist wrapping.</p>
        </article>
    @empty
        <article class="rounded-3xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-2">
            Category highlights will appear after products are available.
        </article>
    @endforelse
</section>

<section class="mt-12">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="font-serif text-3xl font-semibold text-gray-900">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-rose-600 transition hover:text-rose-700">View all products</a>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($featuredProducts as $product)
            <article class="group overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <a href="{{ route('products.show', $product) }}" class="relative block overflow-hidden">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-60 w-full object-cover transition duration-500 group-hover:scale-105">
                    <span class="absolute right-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-rose-600 shadow-sm">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                </a>
                <div class="p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-700">{{ $product->category->name ?? 'Flower' }}</p>
                    <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-gray-700 transition hover:text-gray-900">Details</a>
                        @auth
                            <form method="POST" action="{{ route('cart.store') }}" class="opacity-0 transition duration-300 group-hover:opacity-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5">
                                    Add to cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="opacity-0 text-xs font-semibold text-rose-600 transition duration-300 group-hover:opacity-100">Login to buy</a>
                        @endauth
                    </div>
                </div>
            </article>
        @empty
            <p class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-500">No featured products yet.</p>
        @endforelse
    </div>
</section>
@endsection
