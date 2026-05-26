<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Xác thực OTP - {{ config('app.name', 'Tuki Fresh Flower') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:500,600,700|figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-lux-bg text-lux-text antialiased">
    <div class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_50%_30%,rgba(229,192,123,0.08),transparent_50%)] px-4 py-10">

        <div class="w-full max-w-sm animate-fade-in-up">
            {{-- Brand --}}
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-block font-serif text-2xl font-semibold text-lux-gold">
                    Tuki Fresh Flower
                </a>
            </div>

            {{-- Card --}}
            <div class="rounded-3xl border border-white/5 bg-lux-card p-8 shadow-2xl">
                {{-- Icon --}}
                <div class="mb-5 flex justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-lux-gold/10 text-lux-gold">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-center font-serif text-2xl font-semibold text-lux-text">Xác thực Email</h1>
                <p class="mt-2 text-center text-sm text-lux-text/60">
                    Chúng tôi đã gửi mã xác thực 6 chữ số đến
                    <span class="block mt-1 font-semibold text-lux-gold">{{ $email }}</span>
                </p>

                {{-- Error messages --}}
                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-center text-sm text-red-400">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- OTP Form --}}
                <form method="POST" action="{{ route('verify-otp.verify') }}" class="mt-6 space-y-5">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div>
                        <label for="otp" class="mb-2 block text-center text-xs font-medium uppercase tracking-widest text-lux-text/50">Nhập mã OTP</label>
                        <input
                            id="otp"
                            type="text"
                            name="otp"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            autocomplete="one-time-code"
                            required
                            autofocus
                            placeholder="● ● ● ● ● ●"
                            class="block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-4 text-center text-2xl font-bold tracking-[0.5em] text-lux-gold placeholder-lux-text/20 transition focus:border-lux-gold focus:outline-none focus:ring-2 focus:ring-lux-gold/30"
                        >
                    </div>

                    {{-- Countdown --}}
                    <div class="text-center">
                        <p class="text-xs text-lux-text/40">Mã hết hạn sau</p>
                        <p class="mt-1 font-mono text-lg font-bold text-lux-gold" id="otp-countdown">05:00</p>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        id="otp-submit-btn"
                        class="w-full rounded-xl bg-lux-gold py-3 text-sm font-bold text-lux-bg shadow-lg shadow-lux-gold/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-lux-gold/30 focus:outline-none focus:ring-2 focus:ring-lux-gold/40 focus:ring-offset-2 focus:ring-offset-lux-bg active:scale-[0.98]"
                    >
                        Xác thực
                    </button>
                </form>

                {{-- Resend / Back --}}
                <div class="mt-5 space-y-2 text-center text-sm">
                    <p class="text-lux-text/40">
                        Không nhận được mã?
                        <a href="{{ route('register') }}" class="font-semibold text-lux-gold transition hover:text-lux-gold/80">Đăng ký lại</a>
                    </p>
                </div>
            </div>

            {{-- Security note --}}
            <p class="mt-4 text-center text-xs text-lux-text/25">
                <svg class="mr-1 inline h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
                Bảo mật OTP · Tối đa 3 lần thử · Hết hạn sau 5 phút
            </p>
        </div>
    </div>

    {{-- Countdown Script --}}
    <script>
        (function() {
            let timeLeft = 5 * 60;
            const timerEl = document.getElementById('otp-countdown');
            const submitBtn = document.getElementById('otp-submit-btn');
            if (!timerEl) return;

            const interval = setInterval(function() {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    timerEl.textContent = '00:00';
                    timerEl.classList.add('text-red-400');
                    timerEl.classList.remove('text-lux-gold');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-40', 'cursor-not-allowed');
                        submitBtn.textContent = 'Mã đã hết hạn';
                    }
                    return;
                }
                const minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
                const seconds = (timeLeft % 60).toString().padStart(2, '0');
                timerEl.textContent = minutes + ':' + seconds;
            }, 1000);
        })();
    </script>
</body>
</html>
