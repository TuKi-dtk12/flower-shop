@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-serif text-3xl font-semibold text-lux-gold">Quản lý đơn hàng</h1>
        <span class="rounded-full bg-lux-gold/10 px-3 py-1 text-xs font-semibold text-lux-gold">Trạng thái: pending, completed, cancelled</span>
    </div>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="mt-5 grid grid-cols-1 gap-3 rounded-2xl border border-white/5 bg-lux-bg p-4 md:grid-cols-5">
        <div class="md:col-span-2">
            <label for="q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-lux-text/50">Tìm đơn hàng/khách</label>
            <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="Mã đơn hoặc tên khách" class="w-full rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text placeholder-lux-text/40 focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-lux-text/50">Trạng thái</label>
            <select id="status" name="status" class="w-full rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </div>

        <div>
            <label for="date_from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-lux-text/50">Từ ngày</label>
            <input id="date_from" type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label for="date_to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-lux-text/50">Đến ngày</label>
            <input id="date_to" type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div class="md:col-span-5 flex flex-wrap items-center justify-between gap-2 pt-1">
            <p class="text-sm text-lux-text/60">Tìm thấy <span class="font-semibold text-lux-gold">{{ $orders->total() }}</span> đơn hàng</p>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold text-lux-text/70 transition hover:bg-white/5">Đặt lại</a>
                <button type="submit" class="rounded-lg bg-lux-gold px-4 py-2 text-sm font-semibold text-lux-bg transition hover:shadow-lg">Lọc</button>
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6 space-y-4">
        @forelse ($orders as $order)
            <article class="rounded-2xl border border-white/5 bg-lux-bg p-4">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-lux-text">Đơn hàng #{{ $order->id }}</h2>
                        <p class="text-sm text-lux-text/60">Khách: {{ $order->user->name ?? 'Unknown' }} ({{ $order->user->email ?? '-' }})</p>
                        <p class="text-sm text-lux-text/60">Ngày đặt: {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                        <p class="mt-1 text-sm font-semibold text-lux-gold">Tổng: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                    </div>

                    <div class="flex flex-col items-start gap-2 sm:items-end">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'completed' ? 'bg-emerald-900/60 text-emerald-300' : ($order->status === 'cancelled' ? 'bg-white/10 text-lux-text/60' : 'bg-amber-900/40 text-amber-300') }}">
                                {{ ucfirst($order->status) }}
                            </span>

                            {{-- Payment Method Badge --}}
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ ($order->payment_method ?? 'cod') === 'bank_transfer' ? 'bg-blue-900/40 text-blue-300' : 'bg-white/10 text-lux-text/60' }}">
                                {{ ($order->payment_method ?? 'cod') === 'bank_transfer' ? '🏦 Chuyển khoản' : '💵 COD' }}
                            </span>

                            {{-- Payment Status Badge --}}
                            @if(($order->payment_method ?? 'cod') === 'bank_transfer')
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ ($order->payment_status ?? 'pending') === 'paid' ? 'bg-emerald-900/60 text-emerald-300' : (($order->payment_status ?? 'pending') === 'failed' ? 'bg-red-900/40 text-red-300' : 'bg-amber-900/40 text-amber-300') }}">
                                    {{ ($order->payment_status ?? 'pending') === 'paid' ? '✅ Đã TT' : (($order->payment_status ?? 'pending') === 'failed' ? '❌ Thất bại' : '⏳ Chờ TT') }}
                                </span>
                            @endif
                        </div>

                        {{-- Order Status Update --}}
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label for="status-{{ $order->id }}" class="sr-only">Cập nhật trạng thái</label>
                            <select id="status-{{ $order->id }}" name="status" class="min-w-[150px] rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            <button type="submit" class="rounded-lg bg-lux-gold/20 px-3 py-2 text-sm font-semibold text-lux-gold transition hover:bg-lux-gold/30">Cập nhật</button>
                        </form>

                        {{-- Payment Status Update (only for bank transfer orders) --}}
                        @if(($order->payment_method ?? 'cod') === 'bank_transfer')
                            <form method="POST" action="{{ route('admin.orders.update-payment-status', $order) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="payment-status-{{ $order->id }}" class="sr-only">Cập nhật thanh toán</label>
                                <select id="payment-status-{{ $order->id }}" name="payment_status" class="min-w-[150px] rounded-lg border border-white/10 bg-lux-card px-3 py-2 text-sm text-lux-text focus:border-lux-gold focus:outline-none">
                                    <option value="pending" {{ ($order->payment_status ?? 'pending') === 'pending' ? 'selected' : '' }}>⏳ Chờ TT</option>
                                    <option value="paid" {{ ($order->payment_status ?? 'pending') === 'paid' ? 'selected' : '' }}>✅ Đã TT</option>
                                    <option value="failed" {{ ($order->payment_status ?? 'pending') === 'failed' ? 'selected' : '' }}>❌ Thất bại</option>
                                </select>
                                <button type="submit" class="rounded-lg bg-blue-500/20 px-3 py-2 text-sm font-semibold text-blue-300 transition hover:bg-blue-500/30">Xác nhận</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead class="bg-lux-card">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-lux-gold/80">Sản phẩm</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-lux-gold/80">Đơn giá</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-lux-gold/80">SL</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-lux-gold/80">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-lux-text">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</td>
                                    <td class="px-3 py-2 text-sm text-lux-text/70">{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                    <td class="px-3 py-2 text-sm text-lux-text/70">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2 text-sm font-medium text-lux-gold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-white/10 bg-lux-bg p-8 text-center text-lux-text/50">Không có đơn hàng nào.</div>
        @endforelse
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
