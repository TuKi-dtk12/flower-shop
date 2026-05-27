<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Register') }} - {{ config('app.name', 'Tuki Fresh Flower') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:500,600,700|figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-lux-bg text-lux-text antialiased">
    <div class="relative min-h-screen overflow-hidden bg-lux-bg lg:grid lg:grid-cols-2">
        <aside class="relative hidden h-screen lg:block">
            <img
                src="https://images.unsplash.com/photo-1468327768560-75b778cbb551?auto=format&fit=crop&w=1800&q=80"
                alt="Floral luxury arrangement"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-tr from-black/55 via-emerald-900/25 to-black/55"></div>

            <div class="absolute bottom-10 left-10 right-10 rounded-3xl border border-white/30 bg-white/15 p-8 text-white backdrop-blur-md">
                <p class="mb-3 text-xs uppercase tracking-[0.28em] text-lux-gold/90">Luxury Membership</p>
                <h2 class="font-['Playfair_Display'] text-4xl font-semibold leading-tight">Bắt Đầu Hành Trình Hoa Tươi Của Bạn Cùng Chúng Tôi</h2>
                <p class="mt-4 text-sm text-lux-text/80">Tạo tài khoản để tận hưởng những bó hoa tuyển chọn, thanh toán nhanh và quà tặng cá nhân hóa.</p>
            </div>
        </aside>

        <section class="relative flex min-h-screen items-center justify-center bg-lux-bg px-6 py-10 sm:px-8 lg:px-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_5%,rgba(229,192,123,0.12),transparent_46%),radial-gradient(circle_at_0%_100%,rgba(16,185,129,0.15),transparent_44%)] lg:hidden"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-white/5 bg-lux-card p-7 shadow-2xl sm:p-9">
                <div class="mb-7">
                    <a href="{{ route('home') }}" class="inline-block font-['Playfair_Display'] text-3xl font-semibold text-lux-gold">
                        Tuki Fresh Flower
                    </a>
                    <h1 class="mt-5 font-['Playfair_Display'] text-4xl font-semibold text-lux-text">Đăng Ký Tài Khoản</h1>
                    <p class="mt-2 text-sm text-lux-text/70">Gia nhập Tuki Fresh Flower để trải nghiệm dịch vụ hoa tươi cao cấp.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Họ và tên')" class="text-sm font-medium text-lux-text/80" />
                        <x-text-input
                            id="name"
                            class="mt-2 block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold focus:ring-lux-gold/30"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Full name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-rose-200" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Địa chỉ Email')" class="text-sm font-medium text-lux-text/80" />
                        <x-text-input
                            id="email"
                            class="mt-2 block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold focus:ring-lux-gold/30"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="Name@gmail.com"
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
                            autocomplete="new-password"
                            placeholder="Password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-200" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" class="text-sm font-medium text-lux-text/80" />
                        <x-text-input
                            id="password_confirmation"
                            class="mt-2 block w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-3 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold focus:ring-lux-gold/30"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-rose-200" />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-lux-gold px-4 py-3 text-sm font-bold text-lux-bg shadow-2xl transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#d4b06a] focus:outline-none focus:ring-2 focus:ring-lux-gold/40 focus:ring-offset-2 focus:ring-offset-lux-bg"
                    >
                        {{ __('Đăng ký') }}
                    </button>

                    <p class="text-center text-sm text-lux-text/70">
                        {{ __('Bạn đã có tài khoản?') }}
                        <a href="{{ route('login') }}" class="font-semibold text-lux-gold underline-offset-4 transition hover:text-lux-gold/80 hover:underline">
                            {{ __('Đăng nhập ngay') }}
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
