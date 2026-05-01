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
                <p class="text-xs text-rose-50">Tu van mau hoa theo dip le va cam xuc cua ban</p>
            </header>

            <div id="flower-chatbot-messages" class="max-h-80 space-y-3 overflow-y-auto bg-white/80 p-4 text-sm">
                <div class="max-w-[85%] rounded-2xl rounded-tl-sm bg-emerald-50 px-3 py-2 text-emerald-900">
                    Xin chao, minh la tro ly tu van cua Fresh Flower. Ban muon tim hoa cho dip nao?
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
                        placeholder="Vi du: Goi y bo hoa cho ky niem ngay cuoi, ngan sach 700k"
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
