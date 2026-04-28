<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fresh Flower Shop') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|playfair+display:500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-rose-50 via-white to-emerald-50 text-floral-charcoal antialiased">
    @php
        $navCategories = \Illuminate\Support\Facades\Schema::hasTable('categories')
            ? \App\Models\Category::orderBy('name')->get()
            : collect();
    @endphp

    <nav class="sticky top-0 z-40 border-b border-white/70 bg-white/65 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex w-full max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold text-rose-600">
                Fresh Flower
            </a>

            <div class="flex flex-wrap items-center gap-2 text-sm">
                <a href="{{ route('products.index') }}" class="rounded-full border border-rose-200 px-4 py-1.5 text-rose-700 transition hover:bg-rose-100">
                    All Flowers
                </a>
                @foreach ($navCategories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="rounded-full border border-emerald-200 px-4 py-1.5 text-emerald-700 transition hover:bg-emerald-100">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-emerald-300 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">
                            Categories
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-emerald-300 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">
                            Products
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-amber-300 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-50">
                            Orders
                        </a>
                    @endif

                    <a href="{{ route('cart.index') }}" class="rounded-lg bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-600">
                        Cart
                    </a>
                @endauth

                @guest
                    <a href="{{ route('register') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                        Register
                    </a>
                    <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                        Login
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl border border-rose-300 bg-rose-50 px-4 py-3 text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        @isset($header)
            <header class="mb-6 rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                {{ $header }}
            </header>
        @endisset

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="mt-10 border-t border-rose-100 bg-white/80">
        <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-gray-600 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>Fresh Flower Shop - Blooming for every moment.</p>
            <p>{{ now()->format('Y') }} | Secure Laravel Checkout</p>
        </div>
    </footer>
</body>
</html>
