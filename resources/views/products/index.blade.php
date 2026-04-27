@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Flower Catalog</h1>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-rose-600 hover:text-rose-700">Back to home</a>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        <a href="{{ route('products.index') }}" class="rounded-full px-4 py-2 text-sm {{ empty($categoryId) ? 'bg-rose-500 text-white' : 'border border-rose-200 text-rose-700 hover:bg-rose-50' }}">All</a>
        @foreach ($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="rounded-full px-4 py-2 text-sm {{ (int) $categoryId === (int) $category->id ? 'bg-emerald-500 text-white' : 'border border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}">{{ $category->name }}</a>
        @endforeach
    </div>
</div>

<div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($products as $product)
        @php
            $isOutOfStock = isset($product->status) && $product->status !== 'active';
        @endphp

        <article class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
            <a href="{{ route('products.show', $product) }}" class="block">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x400?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-56 w-full object-cover">
            </a>
            <div class="p-4">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">{{ $product->category->name ?? 'Flower' }}</p>
                    @if ($isOutOfStock)
                        <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-600">Out of Stock</span>
                    @else
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">In Stock</span>
                    @endif
                </div>
                <h2 class="mt-2 text-lg font-semibold text-gray-900">{{ $product->name }}</h2>
                <p class="mt-1 text-rose-600">{{ number_format($product->price, 0, ',', '.') }} VND</p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('products.show', $product) }}" class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Details</a>

                    @if ($isOutOfStock)
                        <button type="button" disabled class="cursor-not-allowed rounded-lg bg-gray-300 px-3 py-2 text-sm font-semibold text-white">Out of stock</button>
                    @elseif (auth()->check())
                        <form method="POST" action="{{ route('cart.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="rounded-lg bg-rose-500 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-600">Add to Cart</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-rose-500 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-600">Login to buy</a>
                    @endif
                </div>
            </div>
        </article>
    @empty
        <p class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-500">No products found.</p>
    @endforelse
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
