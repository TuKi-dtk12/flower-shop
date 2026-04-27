<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Log in') }} - {{ config('app.name', 'Fresh Flower') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:500,600,700|figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-rose-50 text-gray-800 antialiased">
    <div class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_15%_20%,rgba(251,207,232,0.45),transparent_38%),radial-gradient(circle_at_85%_85%,rgba(167,243,208,0.4),transparent_32%),linear-gradient(180deg,#fff8fb_0%,#fdfdfd_45%,#f0fdf4_100%)] lg:grid lg:grid-cols-2">
        <aside class="relative hidden h-screen lg:block">
            <img
                src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1800&q=80"
                alt="Floral luxury visual"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-tr from-rose-900/45 via-rose-800/15 to-emerald-900/25"></div>

            <div class="absolute bottom-10 left-10 right-10 rounded-3xl border border-white/30 bg-white/15 p-8 text-white backdrop-blur-md">
                <p class="mb-3 text-xs uppercase tracking-[0.28em] text-rose-100">Fresh Flower Collection</p>
                <h2 class="font-['Playfair_Display'] text-4xl font-semibold leading-tight">Where Every Bouquet Feels Like Art</h2>
                <p class="mt-4 text-sm text-rose-50/90">Curated premium flowers for weddings, celebrations, and meaningful moments.</p>
            </div>
        </aside>

        <section class="relative flex min-h-screen items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_0%,rgba(244,114,182,0.12),transparent_45%),radial-gradient(circle_at_0%_100%,rgba(16,185,129,0.15),transparent_45%)] lg:hidden"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-white/60 bg-white/60 p-7 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.4)] backdrop-blur-xl sm:p-9">
                <div class="mb-7">
                    <a href="{{ route('home') }}" class="inline-block font-['Playfair_Display'] text-3xl font-semibold text-rose-600">
                        Fresh Flower
                    </a>
                    <h1 class="mt-5 font-['Playfair_Display'] text-4xl font-semibold text-slate-900">Welcome Back</h1>
                    <p class="mt-2 text-sm text-slate-600">Log in to manage your floral orders and discover new collections.</p>
                </div>

                <x-auth-session-status class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700" />
                        <x-text-input
                            id="email"
                            class="mt-2 block w-full rounded-xl border border-rose-100/80 bg-white/85 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-300 focus:ring-rose-200"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="you@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-600" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700" />
                        <x-text-input
                            id="password"
                            class="mt-2 block w-full rounded-xl border border-rose-100/80 bg-white/85 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-300 focus:ring-rose-200"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-600" />
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label for="remember_me" class="inline-flex items-center text-sm text-slate-600">
                            <input id="remember_me" type="checkbox" class="rounded border-rose-200 text-rose-500 shadow-sm focus:ring-rose-200" name="remember">
                            <span class="ms-2">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-rose-600 underline-offset-4 transition hover:text-rose-700 hover:underline focus:outline-none focus:ring-2 focus:ring-rose-200" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-rose-500 via-pink-500 to-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-200/80 transition duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-rose-300/70 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-offset-2"
                    >
                        {{ __('Log in') }}
                    </button>

                    <p class="text-center text-sm text-slate-600">
                        {{ __('New to Fresh Flower?') }}
                        <a href="{{ route('register') }}" class="font-semibold text-emerald-700 underline-offset-4 transition hover:text-emerald-800 hover:underline">
                            {{ __('Create an account') }}
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
