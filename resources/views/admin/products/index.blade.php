@extends('layouts.app')

@section('content')
<section class="rounded-3xl border border-gray-200 bg-gray-50/80 p-5 shadow-sm sm:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-gray-900">Admin Product Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage catalog quality, pricing, and inventory visibility.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">+ New Product</a>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($products as $product)
            @php
                $inStock = isset($product->status) ? $product->status === 'active' : true;
            @endphp
            <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-xl sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/120x90?text=Flower' }}" alt="{{ $product->name }}" class="h-16 w-24 rounded-xl object-cover">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h2>
                                @if ($inStock)
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">In Stock</span>
                                @else
                                    <span class="rounded-full bg-gray-200 px-2.5 py-1 text-xs font-semibold text-gray-700">Out of Stock</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-600">{{ $product->category->name ?? '-' }} • {{ number_format($product->price, 0, ',', '.') }} VND</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-emerald-300 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-50">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-rose-300 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">No products found.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
</section>
@endsection
