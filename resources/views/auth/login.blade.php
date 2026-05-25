<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Log in') }} - {{ config('app.name', 'Tuki Fresh Flower') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:500,600,700|figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-lux-bg text-lux-text antialiased">
    <div class="relative min-h-screen overflow-hidden bg-lux-bg lg:grid lg:grid-cols-2">
        <aside class="relative hidden h-screen lg:block">
            <img
                src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1800&q=80"
                alt="Floral luxury visual"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-tr from-black/50 via-emerald-900/30 to-black/50"></div>

            <div class="absolute bottom-10 left-10 right-10 rounded-3xl border border-white/30 bg-white/15 p-8 text-white backdrop-blur-md">
                <p class="mb-3 text-xs uppercase tracking-[0.28em] text-lux-gold/90">Tuki Fresh Flower Collection</p>
                <h2 class="font-['Playfair_Display'] text-4xl font-semibold leading-tight">Nơi Mỗi Đóa Hoa Là Một Tác Phẩm Nghệ Thuật</h2>
                <p class="mt-4 text-sm text-lux-text/80">Hoa tươi cao cấp tuyển chọn cho ngày cưới, ngày lễ và những khoảnh khắc ý nghĩa.</p>
            </div>
        </aside>

        <section class="relative flex min-h-screen items-center justify-center bg-lux-bg px-6 py-10 sm:px-8 lg:px-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_0%,rgba(229,192,123,0.12),transparent_45%),radial-gradient(circle_at_0%_100%,rgba(16,185,129,0.15),transparent_45%)] lg:hidden"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-white/5 bg-lux-card p-7 shadow-2xl sm:p-9">
                <div class="mb-7">
                    <a href="{{ route('home') }}" class="inline-block font-['Playfair_Display'] text-3xl font-semibold text-lux-gold">
                        Tuki Fresh Flower
                    </a>
                    <h1 class="mt-5 font-['Playfair_Display'] text-4xl font-semibold text-lux-text">Chào Mừng Trở Lại</h1>
                    <p class="mt-2 text-sm text-lux-text/70">Đăng nhập để quản lý đơn hàng hoa và khám phá các bộ sưu tập mới.</p>
                </div>

                <x-auth-session-status class="mb-5 rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text/80" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Địa chỉ Email')" class="text-sm font-medium text-lux-text/80" />
                        <x-text-input
                            id="email"
                            class="mt-2 block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold focus:ring-lux-gold/30"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="ban@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-200" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Mật khẩu')" class="text-sm font-medium text-lux-text/80" />
                        <x-text-input
                            id="password"
                            class="mt-2 block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold focus:ring-lux-gold/30"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Nhap mat khau"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-200" />
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label for="remember_me" class="inline-flex items-center text-sm text-lux-text/80">
                            <input id="remember_me" type="checkbox" class="rounded border-white/20 bg-lux-bg text-lux-gold shadow-sm focus:ring-lux-gold/30" name="remember">
                            <span class="ms-2">{{ __('Ghi nhớ đăng nhập') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-lux-gold underline-offset-4 transition hover:text-lux-gold/80 hover:underline focus:outline-none focus:ring-2 focus:ring-lux-gold/30" href="{{ route('password.request') }}">
                                {{ __('Quên mật khẩu?') }}
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-lux-gold px-4 py-3 text-sm font-bold text-lux-bg shadow-2xl transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#d4b06a] focus:outline-none focus:ring-2 focus:ring-lux-gold/40 focus:ring-offset-2 focus:ring-offset-lux-bg"
                    >
                        {{ __('Đăng nhập') }}
                    </button>

                    <p class="text-center text-sm text-lux-text/70">
                        {{ __('Bạn mới biết đến Tuki Fresh Flower?') }}
                        <a href="{{ route('register') }}" class="font-semibold text-lux-gold underline-offset-4 transition hover:text-lux-gold/80 hover:underline">
                            {{ __('Đăng ký tài khoản') }}
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
