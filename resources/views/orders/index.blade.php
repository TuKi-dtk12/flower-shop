@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">My Orders</h1>

    <div class="mt-6 space-y-3">
        @forelse ($orders as $order)
            <div class="rounded-2xl border border-gray-200 p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm font-semibold text-gray-900">Order #{{ $order->id }}</p>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-gray-200 text-gray-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($order->status) }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-600">Placed: {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                <p class="text-sm font-semibold text-rose-600">Total: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-gray-500">You do not have any orders yet.</div>
        @endforelse
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
