@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <section class="lg:col-span-2 rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
        <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Checkout</h1>
        <p class="mt-2 text-sm text-gray-600">Enter shipping information and confirm your order.</p>

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Receiver name</label>
                <input type="text" name="shipping_name" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="John Doe">
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="shipping_phone" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="0900000000">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="shipping_email" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="name@example.com">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Shipping address</label>
                <textarea name="shipping_address" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="Street, District, City"></textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Note</label>
                <textarea name="note" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="Optional note"></textarea>
            </div>

            <button type="submit" {{ empty($cart) ? 'disabled' : '' }} class="rounded-xl bg-rose-500 px-6 py-3 text-sm font-semibold text-white hover:bg-rose-600 disabled:cursor-not-allowed disabled:bg-gray-300">Place order</button>
        </form>
    </section>

    <aside class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>

        <div class="mt-4 space-y-3">
            @forelse ($cart as $item)
                <div class="flex items-start justify-between gap-3 border-b border-gray-100 pb-3 text-sm">
                    <div>
                        <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                        <p class="text-gray-500">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-semibold text-rose-600">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VND</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">No items in cart.</p>
            @endforelse
        </div>

        <div class="mt-5 rounded-xl bg-rose-50 p-4">
            <div class="flex items-center justify-between text-base font-semibold text-gray-900">
                <span>Total</span>
                <span>{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
        </div>
    </aside>
</div>
@endsection
