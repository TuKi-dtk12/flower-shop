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
<body class="min-h-screen bg-organic-sage text-floral-charcoal antialiased">
    <div class="min-h-screen organic-mesh organic-grain">
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

    <footer class="mt-14 border-t border-white/10 bg-organic-forest text-white">
        <div class="mx-auto w-full max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <div>
                        <p class="font-serif text-2xl font-semibold text-white">Fresh Flower</p>
                        <p class="mt-2 text-sm text-white/70">Fresh blooms, curated with care.</p>
                    </div>
                    <div class="space-y-2 text-sm text-white/70">
                        <p><span class="font-medium text-white">Address:</span> 72/34 Dương Đức Hiền, Tây Thạnh, TPHCM</p>
                        <p><span class="font-medium text-white">Phone:</span> 0866384257</p>
                        <p><span class="font-medium text-white">Email:</span> tuankiet121305@gmail.com</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/tu4nk13t" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-white/20" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M13.5 8.5V7.2c0-.6.4-1 1-1h1.6V4h-2.2c-2 0-3.4 1.5-3.4 3.6v.9H9v2.4h1.5V20h3v-9.1h2l.4-2.4h-2.4z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/i_tki3t/" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-white/20" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm10 2H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm-5 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9zm0 2a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm4.7-2.3a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </a>
                        <a href="https://www.tiktok.com/@tu4nki3t?lang=vi-VN" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-white/20" aria-label="TikTok">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M16.4 4c.6.8 1.6 1.4 2.6 1.6v2.5c-1.2 0-2.3-.4-3.3-1v6.2a5.4 5.4 0 1 1-5.4-5.4c.3 0 .6 0 .9.1v2.7a2.6 2.6 0 1 0 2.5 2.6V4h2.7z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold uppercase tracking-wide text-white">Quick Links</p>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="{{ route('about') }}" class="transition hover:text-white">About Us</a></li>
                        <li><a href="{{ route('products.index') }}" class="transition hover:text-white">All Products</a></li>
                        <li><a href="{{ route('blog') }}" class="transition hover:text-white">Blog</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold uppercase tracking-wide text-white">Policies</p>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="{{ route('policies.privacy') }}" class="transition hover:text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('policies.delivery') }}" class="transition hover:text-white">Delivery Policy</a></li>
                        <li><a href="{{ route('policies.terms') }}" class="transition hover:text-white">Terms of Service</a></li>
                        <li><a href="{{ route('policies.refund') }}" class="transition hover:text-white">Return &amp; Refund</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-sm text-white/70 shadow-sm">
                        <p class="font-semibold text-white">Trust &amp; Security</p>
                        <p class="mt-1">TLS 1.3 secured checkout • PCI-DSS aligned • Daily risk monitoring</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-6 border-t border-white/10 pt-6 text-sm text-white/70 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white/60">Payments</span>
                    <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white">Visa</span>
                    <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white">Mastercard</span>
                    <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white">MoMo</span>
                </div>
                <p>© 2026 Fresh Flower. All rights reserved.</p>
            </div>
        </div>
    </footer>
    </div>

    <div id="flower-chatbot" data-endpoint="{{ route('chat.consult') }}" class="fixed bottom-5 right-5 z-50">
        <button
            id="flower-chatbot-toggle"
            type="button"
            class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-r from-rose-500 to-emerald-500 text-white shadow-xl transition hover:-translate-y-1"
            aria-expanded="false"
            aria-controls="flower-chatbot-panel"
        >
            <span class="sr-only">Open smart flower consultant</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m6-2a9 9 0 10-17.999.001A9 9 0 0019 12z" />
            </svg>
        </button>

        <section
            id="flower-chatbot-panel"
            class="mt-3 hidden w-[22rem] max-w-[calc(100vw-2rem)] overflow-hidden rounded-3xl border border-white/70 bg-white/85 shadow-2xl backdrop-blur-xl"
        >
            <header class="bg-gradient-to-r from-rose-500 to-emerald-500 px-4 py-3 text-white">
                <h3 class="font-serif text-lg font-semibold">Smart Flower Consultant</h3>
                <p class="text-xs text-rose-50">Tư vấn mẫu hoa theo dịp lễ và yêu cầu của bạn</p>
            </header>

            <div id="flower-chatbot-messages" class="max-h-80 space-y-3 overflow-y-auto bg-white/80 p-4 text-sm">
                <div class="max-w-[85%] rounded-2xl rounded-tl-sm bg-emerald-50 px-3 py-2 text-emerald-900">
                    Hiii, mình là trợ lý tư vấn mẫu hoa của Fresh Flower. Bạn muốn tìm hoa cho dịp nào?
                </div>
            </div>

            <form id="flower-chatbot-form" class="border-t border-gray-200 bg-white p-3">
                @csrf
                <label for="flower-chatbot-input" class="sr-only">Message</label>
                <div class="flex items-end gap-2">
                    <textarea
                        id="flower-chatbot-input"
                        name="message"
                        rows="1"
                        maxlength="500"
                        placeholder="Ví dụ: Gợi ý bó hoa kỷ niệm ngày cưới, ngân sách 700k"
                        class="max-h-28 min-h-[44px] flex-1 resize-y rounded-xl border border-rose-100 bg-white px-3 py-2 text-sm text-gray-800 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200"
                    ></textarea>
                    <button
                        id="flower-chatbot-send"
                        type="submit"
                        class="rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Send
                    </button>
                </div>
            </form>
        </section>
    </div>

    <script>
        (function () {
            const chatbotRoot = document.getElementById('flower-chatbot');
            const toggleButton = document.getElementById('flower-chatbot-toggle');
            const panel = document.getElementById('flower-chatbot-panel');
            const form = document.getElementById('flower-chatbot-form');
            const input = document.getElementById('flower-chatbot-input');
            const sendButton = document.getElementById('flower-chatbot-send');
            const messageBox = document.getElementById('flower-chatbot-messages');
            const endpoint = chatbotRoot?.dataset.endpoint || '';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            if (!chatbotRoot || !toggleButton || !panel || !form || !input || !sendButton || !messageBox || !endpoint) {
                return;
            }

            const appendMessage = (text, role) => {
                const wrapper = document.createElement('div');
                wrapper.className = role === 'user'
                    ? 'ml-auto max-w-[85%] rounded-2xl rounded-br-sm bg-rose-500 px-3 py-2 text-white'
                    : 'max-w-[85%] rounded-2xl rounded-tl-sm bg-emerald-50 px-3 py-2 text-emerald-900';
                wrapper.textContent = text;
                messageBox.appendChild(wrapper);
                messageBox.scrollTop = messageBox.scrollHeight;
            };

            toggleButton.addEventListener('click', function () {
                const isHidden = panel.classList.contains('hidden');
                panel.classList.toggle('hidden');
                toggleButton.setAttribute('aria-expanded', String(isHidden));

                if (isHidden) {
                    input.focus();
                }
            });

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                const rawMessage = input.value;
                const message = rawMessage.trim();

                if (message.length < 2) {
                    return;
                }

                appendMessage(message, 'user');
                input.value = '';
                sendButton.disabled = true;
                sendButton.textContent = '...';

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ message }),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const errorMessage = (data && (data.message || data.error))
                            ? data.message || data.error
                            : 'Co loi xay ra, vui long thu lai.';
                        appendMessage(errorMessage, 'bot');
                        return;
                    }

                    appendMessage(data.reply || 'Minh chua co de xuat phu hop luc nay.', 'bot');
                } catch (error) {
                    appendMessage('Khong the ket noi den tro ly luc nay. Ban thu lai sau it phut nhe.', 'bot');
                } finally {
                    sendButton.disabled = false;
                    sendButton.textContent = 'Send';
                    input.focus();
                }
            });
        })();
    </script>
</body>
</html>
