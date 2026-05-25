@extends('layouts.app')

@section('content')
<section class="flex min-h-[60vh] items-center justify-center animate-fade-in-up">
    <div class="w-full max-w-md">
        {{-- Main Card --}}
        <div class="overflow-hidden rounded-3xl border border-white/5 bg-lux-card shadow-2xl">
            {{-- Header --}}
            <div class="border-b border-white/5 bg-gradient-to-r from-lux-card to-lux-bg px-6 py-5 text-center">
                <p class="text-xs uppercase tracking-[0.2em] text-lux-gold/70">Thanh toán đơn hàng</p>
                <h1 class="mt-1 font-serif text-2xl font-semibold text-lux-text">Đơn hàng #{{ $order->id }}</h1>
            </div>

            <div class="space-y-5 p-6">
                {{-- Amount --}}
                <div class="text-center">
                    <p class="text-xs uppercase tracking-widest text-lux-text/50">Tổng thanh toán</p>
                    <p class="mt-1 font-serif text-3xl font-bold text-lux-gold">{{ number_format($order->total_price, 0, ',', '.') }} <span class="text-lg">VND</span></p>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center">
                    <div class="relative rounded-2xl border-2 border-lux-gold/30 bg-white p-3 shadow-lg shadow-lux-gold/5">
                        {{-- Gold glow effect --}}
                        <div class="absolute -inset-1 rounded-2xl bg-gradient-to-br from-lux-gold/20 via-transparent to-lux-gold/10 blur-sm"></div>
                        <div class="relative">
                            <img src="{{ $qrUrl }}" alt="VietQR Payment" class="h-56 w-56 object-contain" id="qr-code-image" loading="eager">
                        </div>
                    </div>
                </div>
                <p class="text-center text-xs text-lux-text/50">Mở app Ngân hàng → Quét mã QR</p>

                {{-- Bank Details --}}
                <div class="space-y-2.5 rounded-2xl border border-white/5 bg-lux-bg/60 p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-lux-text/50">Ngân hàng</span>
                        <span class="text-sm font-semibold text-lux-text">{{ $paymentSetting->bank_name }}</span>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-lux-text/50">Số tài khoản</span>
                        <span class="text-sm font-semibold text-lux-text">{{ $paymentSetting->account_number }}</span>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-lux-text/50">Chủ tài khoản</span>
                        <span class="text-sm font-semibold text-lux-text">{{ $paymentSetting->account_name }}</span>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-lux-text/50">Nội dung CK</span>
                        <span class="rounded-lg bg-lux-gold/10 px-3 py-1 text-sm font-bold text-lux-gold">{{ $transferContent }}</span>
                    </div>
                </div>

                {{-- Countdown Timer --}}
                <div class="text-center">
                    <p class="text-xs text-lux-text/40">Vui lòng hoàn tất thanh toán trong</p>
                    <p class="mt-1 font-mono text-lg font-bold text-lux-gold" id="countdown-timer">15:00</p>
                </div>

                {{-- Actions --}}
                <div class="space-y-3">
                    <form method="POST" action="{{ route('payment.confirm', $order) }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-lux-gold to-yellow-600 px-6 py-3 text-sm font-bold text-lux-bg shadow-lg shadow-lux-gold/20 transition duration-300 hover:shadow-xl hover:shadow-lux-gold/30 active:scale-[0.98]">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                Tôi đã chuyển khoản
                            </span>
                        </button>
                    </form>

                    <a href="{{ route('orders.index') }}" class="block text-center text-sm text-lux-text/50 transition hover:text-lux-gold">
                        ← Quay lại đơn hàng
                    </a>
                </div>
            </div>
        </div>

        {{-- Security note --}}
        <p class="mt-4 text-center text-xs text-lux-text/30">
            <svg class="mr-1 inline h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
            </svg>
            Giao dịch được bảo mật · Powered by VietQR
        </p>
    </div>
</section>

{{-- Countdown Timer Script --}}
<script>
    (function() {
        let timeLeft = 15 * 60;
        const timerEl = document.getElementById('countdown-timer');
        if (!timerEl) return;

        const interval = setInterval(function() {
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(interval);
                timerEl.textContent = '00:00';
                timerEl.classList.add('text-red-400');
                timerEl.classList.remove('text-lux-gold');
                return;
            }
            const minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
            const seconds = (timeLeft % 60).toString().padStart(2, '0');
            timerEl.textContent = minutes + ':' + seconds;
        }, 1000);
    })();
</script>
@endsection
