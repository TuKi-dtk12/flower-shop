<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Register') }} - {{ config('app.name', 'Fresh Flower') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:500,600,700|figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-rose-50 text-gray-800 antialiased">
    <div class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_8%_18%,rgba(251,207,232,0.5),transparent_35%),radial-gradient(circle_at_92%_82%,rgba(134,239,172,0.35),transparent_33%),linear-gradient(180deg,#fff7fa_0%,#ffffff_50%,#f0fdf4_100%)] lg:grid lg:grid-cols-2">
        <aside class="relative hidden h-screen lg:block">
            <img
                src="https://images.unsplash.com/photo-1468327768560-75b778cbb551?auto=format&fit=crop&w=1800&q=80"
                alt="Floral luxury arrangement"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-900/35 via-rose-900/20 to-rose-900/35"></div>

            <div class="absolute bottom-10 left-10 right-10 rounded-3xl border border-white/30 bg-white/15 p-8 text-white backdrop-blur-md">
                <p class="mb-3 text-xs uppercase tracking-[0.28em] text-rose-100">Luxury Membership</p>
                <h2 class="font-['Playfair_Display'] text-4xl font-semibold leading-tight">Start Your Floral Story With Us</h2>
                <p class="mt-4 text-sm text-rose-50/90">Create an account to enjoy curated bouquets, quick checkout, and personalized gifting.</p>
            </div>
        </aside>

        <section class="relative flex min-h-screen items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_5%,rgba(244,114,182,0.14),transparent_46%),radial-gradient(circle_at_0%_100%,rgba(16,185,129,0.15),transparent_44%)] lg:hidden"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-white/60 bg-white/60 p-7 shadow-[0_24px_80px_-32px_rgba(15,23,42,0.4)] backdrop-blur-xl sm:p-9">
                <div class="mb-7">
                    <a href="{{ route('home') }}" class="inline-block font-['Playfair_Display'] text-3xl font-semibold text-rose-600">
                        Fresh Flower
                    </a>
                    <h1 class="mt-5 font-['Playfair_Display'] text-4xl font-semibold text-slate-900">Create Account</h1>
                    <p class="mt-2 text-sm text-slate-600">Join our floral boutique and make every celebration effortlessly elegant.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-slate-700" />
                        <x-text-input
                            id="name"
                            class="mt-2 block w-full rounded-xl border border-rose-100/80 bg-white/85 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-300 focus:ring-rose-200"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Your full name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-rose-600" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700" />
                        <x-text-input
                            id="email"
                            class="mt-2 block w-full rounded-xl border border-rose-100/80 bg-white/85 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-300 focus:ring-rose-200"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
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
                            autocomplete="new-password"
                            placeholder="Create a password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-600" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-slate-700" />
                        <x-text-input
                            id="password_confirmation"
                            class="mt-2 block w-full rounded-xl border border-rose-100/80 bg-white/85 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-rose-300 focus:ring-rose-200"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Re-enter your password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-rose-600" />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-500 to-rose-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/70 transition duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-300/60 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-offset-2"
                    >
                        {{ __('Register') }}
                    </button>

                    <p class="text-center text-sm text-slate-600">
                        {{ __('Already registered?') }}
                        <a href="{{ route('login') }}" class="font-semibold text-rose-600 underline-offset-4 transition hover:text-rose-700 hover:underline">
                            {{ __('Log in here') }}
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
