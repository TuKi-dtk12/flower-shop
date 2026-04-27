@extends('layouts.app')

@section('content')
<section class="relative overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-100 via-white to-emerald-100 p-8 sm:p-12">
    <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-rose-200/70 blur-2xl"></div>
    <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-emerald-200/70 blur-2xl"></div>

    <div class="relative max-w-2xl">
        <p class="inline-flex rounded-full border border-rose-200 bg-white/70 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-rose-600">
            Fresh Flower Collection
        </p>
        <h1 class="mt-4 font-['Playfair_Display'] text-4xl font-bold leading-tight text-gray-900 sm:text-5xl">
            Blooming Beauty For Every Occasion
        </h1>
        <p class="mt-4 text-base text-gray-600 sm:text-lg">
            Premium fresh flowers for birthdays, opening events, weddings, and thoughtful moments.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="rounded-xl bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-600">
                Explore Products
            </a>
            @auth
                <a href="{{ route('cart.index') }}" class="rounded-xl border border-emerald-300 bg-white px-5 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">
                    View Cart
                </a>
            @endauth
        </div>
    </div>
</section>

<section class="mt-10">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-rose-600 hover:text-rose-700">
            View all
        </a>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($featuredProducts as $product)
            <article class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <a href="{{ route('products.show', $product) }}" class="block">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-52 w-full object-cover">
                </a>
                <div class="p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">{{ $product->category->name ?? 'Flower' }}</p>
                    <h3 class="mt-1 text-base font-semibold text-gray-900">{{ $product->name }}</h3>
                    <p class="mt-2 text-rose-600">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Details</a>
                        @auth
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-600">Add to cart</button>
                            </form>
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
