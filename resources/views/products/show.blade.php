@extends('layouts.app')

@section('content')
<article class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="space-y-3 p-5">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/900x700?text=Fresh+Flower' }}" alt="{{ $product->name }}" class="h-80 w-full rounded-2xl object-cover sm:h-96">

            @if ($product->images->isNotEmpty())
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($product->images as $galleryImage)
                        <img src="{{ asset('storage/' . $galleryImage->image_path) }}" alt="{{ $product->name }} gallery" class="h-24 w-full rounded-xl object-cover">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="p-6 sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">{{ $product->category->name ?? 'Flower' }}</p>
            <h1 class="mt-2 font-['Playfair_Display'] text-4xl font-semibold text-gray-900">{{ $product->name }}</h1>
            <p class="mt-3 text-2xl font-semibold text-rose-600">{{ number_format($product->price, 0, ',', '.') }} VND</p>

            <p class="mt-5 leading-relaxed text-gray-600">{{ $product->description ?: 'Freshly designed floral arrangement for meaningful moments.' }}</p>

            <div class="mt-6 flex flex-wrap gap-3">
                @auth
                    <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" min="1" value="1" class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <button type="submit" class="rounded-lg bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">Add to Cart</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">Login to purchase</a>
                @endauth

                <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Back to list</a>
            </div>
        </div>
    </div>
</article>
@endsection
