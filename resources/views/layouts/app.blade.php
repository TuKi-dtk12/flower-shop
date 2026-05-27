<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Tuki Fresh Flower') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|playfair+display:500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-lux-bg text-lux-text antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_15%_15%,rgba(229,192,123,0.08),transparent_45%),radial-gradient(circle_at_85%_10%,rgba(16,185,129,0.12),transparent_45%)]">
    @php
        $navCategories = \Illuminate\Support\Facades\Schema::hasTable('categories')
            ? \App\Models\Category::orderBy('name')->get()
            : collect();
    @endphp

    <nav class="sticky top-0 z-40 border-b border-white/10 bg-lux-bg/90 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold tracking-wide text-lux-gold">
                Tuki Fresh Flower
            </a>

            @guest
                <div class="hidden flex-1 items-center justify-center gap-5 text-sm font-medium text-lux-text/80 md:flex">
                    <a href="{{ route('products.index') }}" class="border-b border-transparent pb-1 transition hover:border-lux-gold/70 hover:text-lux-gold">Tất cả hoa</a>
                    @foreach ($navCategories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="border-b border-transparent pb-1 transition hover:border-lux-gold/70 hover:text-lux-gold">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endguest

            <div class="flex items-center gap-3 text-sm">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.categories.index') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold/90 transition hover:bg-lux-gold/10">
                            Danh mục
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold/90 transition hover:bg-lux-gold/10">
                            Sản phẩm
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold/90 transition hover:bg-lux-gold/10">
                            Đơn hàng
                        </a>
                        <a href="{{ route('admin.payment-settings.edit') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold/90 transition hover:bg-lux-gold/10">
                            Thanh toán
                        </a>
                    @endif
                    
                    @if (!auth()->user()->is_admin)
                        <a href="tel:0866384257" class="inline-flex items-center gap-1.5 rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold transition hover:bg-lux-gold/10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97a16.616 16.616 0 0 0 6.422 6.422l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                            </svg>
                            Gọi hotline
                        </a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-semibold text-lux-gold transition hover:bg-lux-gold/10">
                        Giỏ hàng
                    </a>
                @endauth

                @guest
                    <a href="{{ route('register') }}" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-medium text-lux-gold transition hover:bg-lux-gold/10">
                        Đăng ký
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full px-3 py-1.5 font-medium text-lux-text/80 transition hover:text-lux-gold">
                        Đăng nhập
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full border border-lux-gold/40 px-4 py-1.5 font-medium text-lux-gold transition hover:bg-lux-gold/10">
                            Đăng xuất
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-700/60 bg-emerald-900/40 px-4 py-3 text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl border border-rose-700/60 bg-rose-900/40 px-4 py-3 text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        @isset($header)
            <header class="mb-6 rounded-2xl border border-white/10 bg-lux-card p-5 shadow-sm">
                {{ $header }}
            </header>
        @endisset

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="mt-14 border-t border-white/10 bg-lux-bg text-lux-text">
        <div class="mx-auto w-full max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <div>
                        <p class="font-serif text-2xl font-semibold text-lux-gold">Tuki Fresh Flower</p>
                        <p class="mt-2 text-sm text-lux-text/70">Hoa tươi mỗi ngày, đong đầy yêu thương.</p>
                    </div>
                    <div class="space-y-2 text-sm text-lux-text/70">
                        <p><span class="font-medium text-lux-text">Địa chỉ:</span> 72/34 Dương Đức Hiền, Tây Thạnh, TPHCM</p>
                        <p><span class="font-medium text-lux-text">Số điện thoại:</span> 0866384257</p>
                        <p><span class="font-medium text-lux-text">Email:</span> tuankiet121305@gmail.com</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/tu4nk13t" class="flex h-9 w-9 items-center justify-center rounded-full border border-lux-gold/30 bg-lux-card text-lux-gold shadow-sm transition hover:-translate-y-0.5 hover:bg-lux-gold/10" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M13.5 8.5V7.2c0-.6.4-1 1-1h1.6V4h-2.2c-2 0-3.4 1.5-3.4 3.6v.9H9v2.4h1.5V20h3v-9.1h2l.4-2.4h-2.4z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/i_tki3t/" class="flex h-9 w-9 items-center justify-center rounded-full border border-lux-gold/30 bg-lux-card text-lux-gold shadow-sm transition hover:-translate-y-0.5 hover:bg-lux-gold/10" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm10 2H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm-5 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9zm0 2a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm4.7-2.3a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </a>
                        <a href="https://github.com/TuKi-dtk12" class="flex h-9 w-9 items-center justify-center rounded-full border border-lux-gold/30 bg-lux-card text-lux-gold shadow-sm transition hover:-translate-y-0.5 hover:bg-lux-gold/10" aria-label="GitHub">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.483 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.137 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z" />
                            </svg>
                        </a>

                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold uppercase tracking-wide text-lux-gold">Liên kết nhanh</p>
                    <ul class="space-y-2 text-sm text-lux-text/70">
                        <li><a href="{{ route('about') }}" class="transition hover:text-lux-gold">Giới thiệu</a></li>
                        <li><a href="{{ route('products.index') }}" class="transition hover:text-lux-gold">Tất cả sản phẩm</a></li>
                        <li><a href="{{ route('blog') }}" class="transition hover:text-lux-gold">Tin tức</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-semibold uppercase tracking-wide text-lux-gold">Chính sách</p>
                    <ul class="space-y-2 text-sm text-lux-text/70">
                        <li><a href="{{ route('policies.privacy') }}" class="transition hover:text-lux-gold">Chính sách bảo mật</a></li>
                        <li><a href="{{ route('policies.delivery') }}" class="transition hover:text-lux-gold">Chính sách giao hàng</a></li>
                        <li><a href="{{ route('policies.terms') }}" class="transition hover:text-lux-gold">Điều khoản dịch vụ</a></li>
                        <li><a href="{{ route('policies.refund') }}" class="transition hover:text-lux-gold">Đổi trả &amp; Hoàn tiền</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-white/10 bg-lux-card p-4 text-sm text-lux-text/70 shadow-sm">
                        <p class="font-semibold text-lux-gold">Tin cậy &amp; Bảo mật</p>
                        <p class="mt-1">• Trang bị giao thức SSL/TLS <br>• Tích hợp thanh toán online<br>• Giám sát rủi ro 24/7</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-6 border-t border-white/10 pt-6 text-sm text-lux-text/70 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold uppercase tracking-wide text-lux-text/60">Founder/Developer/Webmaster</span>
                    <span class="rounded-full border border-lux-gold/30 bg-lux-card px-3 py-1 text-xs font-semibold text-lux-gold">Đinh Tuấn Kiệt</span>
                </div>
                <p>© 2026 Tuki Fresh Flower - Mọi quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
    </div>

    <div id="flower-chatbot" data-endpoint="{{ route('chat.consult') }}" class="fixed bottom-5 right-5 z-50">
        <button
            id="flower-chatbot-toggle"
            type="button"
            class="flex h-14 w-14 items-center justify-center rounded-full bg-lux-gold text-lux-bg shadow-xl transition hover:-translate-y-1"
            aria-expanded="false"
            aria-controls="flower-chatbot-panel"
        >
            <span class="sr-only">Mở trợ lý tư vấn hoa</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m6-2a9 9 0 10-17.999.001A9 9 0 0019 12z" />
            </svg>
        </button>

        <section
            id="flower-chatbot-panel"
            class="mt-3 hidden h-[600px] w-[420px] max-w-[calc(100vw-2rem)] max-h-[80vh] overflow-hidden rounded-3xl border border-white/10 bg-lux-card/90 shadow-2xl backdrop-blur-md flex flex-col"
        >
            <header class="bg-lux-bg px-4 py-3 text-lux-text">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="font-serif text-lg font-semibold">Tuki Chatbox</h3>
                        <p class="text-xs text-lux-text/80">Tư vấn mẫu hoa theo dịp lễ và yêu cầu của bạn</p>
                    </div>
                    <span class="flex items-center gap-2 text-xs font-semibold text-lux-text/80">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-lux-gold/60 opacity-75"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-lux-gold"></span>
                        </span>
                        AI online
                    </span>
                </div>
            </header>

            <div id="flower-chatbot-messages" class="flex-1 space-y-3 overflow-y-auto bg-lux-card/80 p-4 text-sm">
                <div class="flex items-start gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-lux-bg text-lux-gold">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5c3 0 5.5 2.3 5.5 5.1 0 2.6-2.1 5-4.8 5.4-.4.1-.7.5-.7.9v1.2H9.7v-1.2c0-.4-.3-.8-.7-.9C6.6 14.6 4.5 12.2 4.5 9.6 4.5 6.8 7 4.5 10 4.5h2z" />
                        </svg>
                    </span>
                    <div class="max-w-[85%] rounded-2xl rounded-tl-none bg-lux-bg px-3 py-2 text-lux-text text-justify whitespace-pre-line">Hiii, mình là trợ lý tư vấn mẫu hoa của Tuki Fresh Flower. Bạn muốn tìm hoa cho dịp nào?</div>
                </div>
            </div>

            <form id="flower-chatbot-form" class="border-t border-white/10 bg-lux-card p-3">
                @csrf
                <label for="flower-chatbot-input" class="sr-only">Tin nhắn</label>
                <div class="flex items-center gap-2">
                    <input
                        id="flower-chatbot-input"
                        name="message"
                        type="text"
                        maxlength="500"
                        placeholder="Ví dụ: Gợi ý hoa khai trương, ngân sách 700k"
                        class="h-11 flex-1 rounded-full border border-white/10 bg-lux-bg px-4 text-sm text-lux-text placeholder:text-lux-text/50 focus:border-lux-gold/40 focus:outline-none focus:ring-2 focus:ring-lux-gold/30"
                    />
                    <button
                        id="flower-chatbot-send"
                        type="submit"
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-lux-gold text-lux-bg transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span class="sr-only">Gửi</span>
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h13m0 0-4-4m4 4-4 4" />
                        </svg>
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

            const isNearBottom = (element) => {
                const threshold = 48;
                return element.scrollHeight - element.scrollTop - element.clientHeight <= threshold;
            };

            const appendMessage = (text, role, allowHtml = false) => {
                const shouldAutoScroll = isNearBottom(messageBox);
                const row = document.createElement('div');
                row.className = role === 'user'
                    ? 'flex items-start justify-end gap-2'
                    : 'flex items-start gap-2';

                const avatar = document.createElement('span');
                avatar.className = role === 'user'
                    ? 'flex h-8 w-8 items-center justify-center rounded-full bg-organic-crimson/15 text-organic-crimson'
                    : 'flex h-8 w-8 items-center justify-center rounded-full bg-lux-bg text-lux-gold';
                avatar.innerHTML = role === 'user'
                    ? '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm7 7a7 7 0 0 0-14 0" /></svg>'
                    : '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5c3 0 5.5 2.3 5.5 5.1 0 2.6-2.1 5-4.8 5.4-.4.1-.7.5-.7.9v1.2H9.7v-1.2c0-.4-.3-.8-.7-.9C6.6 14.6 4.5 12.2 4.5 9.6 4.5 6.8 7 4.5 10 4.5h2z" /></svg>';

                const bubble = document.createElement('div');
                    bubble.className = role === 'user'
                        ? 'max-w-[80%] rounded-2xl rounded-tr-none bg-organic-coral px-3 py-2 text-white'
                        : 'max-w-[85%] rounded-2xl rounded-tl-none bg-lux-bg px-3 py-2 text-lux-text text-justify whitespace-pre-line';

                if (allowHtml) {
                    bubble.innerHTML = String(text).replace(/\n/g, '<br>');
                } else {
                    bubble.textContent = text;
                }

                if (role === 'user') {
                    row.appendChild(bubble);
                    row.appendChild(avatar);
                } else {
                    row.appendChild(avatar);
                    row.appendChild(bubble);
                }

                messageBox.appendChild(row);
                if (shouldAutoScroll) {
                    messageBox.scrollTop = messageBox.scrollHeight;
                }
            };

            toggleButton.addEventListener('click', function () {
                const isHidden = panel.classList.contains('hidden');
                panel.classList.toggle('hidden');
                toggleButton.setAttribute('aria-expanded', String(isHidden));

                if (isHidden) {
                    input.focus();
                    messageBox.scrollTop = messageBox.scrollHeight;
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

                    const cleanedReply = (data.reply || 'Minh chua co de xuat phu hop luc nay.').replace(/\\/g, '');
                    appendMessage(cleanedReply, 'bot', true);
                } catch (error) {
                    appendMessage('Khong the ket noi den tro ly luc nay. Ban thu lai sau it phut nhe.', 'bot');
                } finally {
                    sendButton.disabled = false;
                    sendButton.innerHTML = '<span class="sr-only">Gửi</span><svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h13m0 0-4-4m4 4-4 4" /></svg>';
                    input.focus();
                }
            });
        })();
    </script>
</body>
</html>
