<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|playfair+display:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    </head>
    <body class="font-sans antialiased text-lux-text bg-lux-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[radial-gradient(circle_at_15%_15%,rgba(229,192,123,0.08),transparent_45%),radial-gradient(circle_at_85%_10%,rgba(16,185,129,0.12),transparent_45%)]">
            <div>
                <a href="/" class="font-serif text-3xl font-semibold tracking-wide text-lux-gold">Tuki Fresh Flower</a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-lux-card border border-white/10 shadow-2xl overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
