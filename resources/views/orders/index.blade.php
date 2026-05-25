@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-white/5 bg-[#08100D] p-6 shadow-sm">
    <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-[#E2E8F0]">My Orders</h1>

    <div class="mt-6 space-y-3">
        @forelse ($orders as $order)
            <div class="rounded-2xl border border-white/5 bg-[#111F1A] p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm font-semibold text-[#E2E8F0]">Order #{{ $order->id }}</p>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'completed' ? 'bg-emerald-800/60 text-white' : ($order->status === 'cancelled' ? 'bg-white/10 text-[#E2E8F0]/70' : 'bg-amber-200/15 text-[#E5C07B]') }}">{{ ucfirst($order->status) }}</span>
                </div>
                <p class="mt-2 text-sm text-[#E2E8F0]/70">Placed: {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                <p class="text-sm font-semibold text-[#E5C07B]">Total: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-white/10 bg-[#111F1A] p-8 text-center text-[#E2E8F0]/70">You do not have any orders yet.</div>
        @endforelse
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
