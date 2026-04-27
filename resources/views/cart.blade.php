@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Your Cart</h1>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-rose-600 hover:text-rose-700">Continue shopping</a>
    </div>

    @if (empty($cart))
        <div class="mt-6 rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-gray-500">Your cart is currently empty.</div>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($cart as $item)
                <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/180x140?text=Flower' }}" alt="{{ $item['name'] }}" class="h-20 w-24 rounded-lg object-cover">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">{{ $item['name'] }}</h2>
                            <p class="text-sm text-rose-600">{{ number_format($item['price'], 0, ',', '.') }} VND</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <button type="submit" class="rounded-lg border border-emerald-300 px-3 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-50">Update</button>
                        </form>

                        <form method="POST" action="{{ route('cart.destroy', $item['product_id']) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-rose-300 px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-2xl bg-rose-50 p-5">
            <div class="flex items-center justify-between text-lg font-semibold text-gray-900">
                <span>Total</span>
                <span>{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="mt-4 inline-flex rounded-lg bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection
