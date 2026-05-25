@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <section class="lg:col-span-2 rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
        <h1 class="font-serif text-3xl font-semibold text-lux-gold">Thanh toán</h1>
        <p class="mt-2 text-sm text-lux-text/60">Nhập thông tin giao hàng và xác nhận đơn hàng.</p>

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-lux-text/70">Tên người nhận</label>
                <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="Nguyễn Văn A">
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-lux-text/70">Số điện thoại</label>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="0900000000">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-lux-text/70">Email</label>
                    <input type="email" name="shipping_email" value="{{ old('shipping_email') }}" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="email@example.com">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-lux-text/70">Địa chỉ giao hàng</label>
                <textarea name="shipping_address" rows="4" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="Số nhà, Đường, Quận, Thành phố">{{ old('shipping_address') }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-lux-text/70">Ghi chú</label>
                <textarea name="note" rows="3" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="Ghi chú (không bắt buộc)">{{ old('note') }}</textarea>
            </div>

            {{-- Payment Method --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-lux-gold">Phương thức thanh toán</label>
                @error('payment_method')
                    <p class="mb-2 text-xs text-red-400">{{ $message }}</p>
                @enderror

                <div class="space-y-2">
                    {{-- COD --}}
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/10 bg-lux-bg px-4 py-3 transition hover:border-lux-gold/30 has-[:checked]:border-lux-gold/50 has-[:checked]:bg-lux-gold/5">
                        <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                            class="h-4 w-4 border-white/20 bg-lux-bg text-lux-gold focus:ring-lux-gold/40">
                        <div>
                            <p class="text-sm font-semibold text-lux-text">💵 Thanh toán khi nhận hàng (COD)</p>
                            <p class="text-xs text-lux-text/50">Thanh toán bằng tiền mặt khi nhận hàng</p>
                        </div>
                    </label>

                    {{-- Bank Transfer / VietQR --}}
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/10 bg-lux-bg px-4 py-3 transition hover:border-lux-gold/30 has-[:checked]:border-lux-gold/50 has-[:checked]:bg-lux-gold/5">
                        <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                            class="h-4 w-4 border-white/20 bg-lux-bg text-lux-gold focus:ring-lux-gold/40">
                        <div>
                            <p class="text-sm font-semibold text-lux-text">🏦 Chuyển khoản ngân hàng (VietQR)</p>
                            <p class="text-xs text-lux-text/50">Quét mã QR để thanh toán — nhanh chóng và chính xác</p>
                        </div>
                    </label>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-400">
                    <p class="font-semibold">Vui lòng kiểm tra lại:</p>
                    <ul class="mt-1 list-inside list-disc text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" {{ empty($cart) ? 'disabled' : '' }} class="rounded-xl bg-lux-gold px-6 py-3 text-sm font-semibold text-lux-bg shadow-lg transition hover:shadow-xl active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-40">Đặt hàng</button>
        </form>
    </section>

    <aside class="rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-lux-gold">Tóm tắt đơn hàng</h2>

        <div class="mt-4 space-y-3">
            @forelse ($cart as $item)
                <div class="flex items-start justify-between gap-3 border-b border-white/5 pb-3 text-sm">
                    <div>
                        <p class="font-medium text-lux-text">{{ $item['name'] }}</p>
                        <p class="text-lux-text/50">SL: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-semibold text-lux-gold">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VND</p>
                </div>
            @empty
                <p class="text-sm text-lux-text/50">Giỏ hàng trống.</p>
            @endforelse
        </div>

        <div class="mt-5 rounded-xl bg-lux-gold/10 p-4">
            <div class="flex items-center justify-between text-base font-semibold">
                <span class="text-lux-text">Tổng cộng</span>
                <span class="text-lux-gold">{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
        </div>
    </aside>
</div>
@endsection
