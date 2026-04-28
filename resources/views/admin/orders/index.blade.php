@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Admin - Order Management</h1>
        <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Statuses: pending, completed, cancelled</span>
    </div>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="mt-5 grid grid-cols-1 gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 md:grid-cols-5">
        <div class="md:col-span-2">
            <label for="q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-600">Search order/customer</label>
            <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Order ID or customer name" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-rose-400 focus:outline-none">
        </div>

        <div>
            <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-600">Status</label>
            <select id="status" name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-rose-400 focus:outline-none">
                <option value="">All</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>pending</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>cancelled</option>
            </select>
        </div>

        <div>
            <label for="date_from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-600">From date</label>
            <input id="date_from" type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-rose-400 focus:outline-none">
        </div>

        <div>
            <label for="date_to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-600">To date</label>
            <input id="date_to" type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-rose-400 focus:outline-none">
        </div>

        <div class="md:col-span-5 flex flex-wrap items-center justify-between gap-2 pt-1">
            <p class="text-sm text-gray-600">Found <span class="font-semibold text-gray-900">{{ $orders->total() }}</span> orders</p>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">Reset</a>
                <button type="submit" class="rounded-lg bg-rose-500 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-600">Apply filters</button>
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6 space-y-4">
        @forelse ($orders as $order)
            <article class="rounded-2xl border border-gray-200 p-4">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h2>
                        <p class="text-sm text-gray-600">Customer: {{ $order->user->name ?? 'Unknown' }} ({{ $order->user->email ?? '-' }})</p>
                        <p class="text-sm text-gray-600">Placed: {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                        <p class="mt-1 text-sm font-semibold text-rose-600">Total: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                    </div>

                    <div class="flex flex-col items-start gap-2 sm:items-end">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-gray-200 text-gray-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($order->status) }}
                        </span>

                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label for="status-{{ $order->id }}" class="sr-only">Update status</label>
                            <select id="status-{{ $order->id }}" name="status" class="min-w-[150px] rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-rose-400 focus:outline-none">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>pending</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>cancelled</option>
                            </select>
                            <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Update</button>
                        </form>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-rose-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Product</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Unit Price</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Qty</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-800">{{ $item->product->name ?? 'Deleted product' }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2 text-sm font-medium text-gray-800">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-gray-500">No orders found.</div>
        @endforelse
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
