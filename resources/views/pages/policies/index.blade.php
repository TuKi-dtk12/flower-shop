@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-4xl space-y-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-400">Chính sách</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Chăm sóc khách hàng và tin cậy</h1>
                <p class="mt-2 text-sm text-gray-600">Xem các chính sách giúp mọi đơn hàng minh bạch và an toàn.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <a href="{{ route('policies.privacy') }}" class="rounded-2xl border border-rose-100 bg-rose-50/40 p-4 transition hover:-translate-y-0.5">
                    <p class="text-sm font-semibold text-rose-600">Chính sách bảo mật</p>
                    <p class="mt-2 text-sm text-gray-600">Cách chúng tôi thu thập, lưu trữ và bảo vệ dữ liệu cá nhân.</p>
                </a>
                <a href="{{ route('policies.delivery') }}" class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-4 transition hover:-translate-y-0.5">
                    <p class="text-sm font-semibold text-emerald-700">Chính sách giao hàng</p>
                    <p class="mt-2 text-sm text-gray-600">Khung giờ giao, phạm vi và lưu ý xử lý đặc biệt.</p>
                </a>
                <a href="{{ route('policies.terms') }}" class="rounded-2xl border border-rose-100 bg-white p-4 transition hover:-translate-y-0.5">
                    <p class="text-sm font-semibold text-gray-800">Điều khoản dịch vụ</p>
                    <p class="mt-2 text-sm text-gray-600">Các điều khoản áp dụng khi mua sắm tại Fresh Flower.</p>
                </a>
                <a href="{{ route('policies.refund') }}" class="rounded-2xl border border-emerald-100 bg-white p-4 transition hover:-translate-y-0.5">
                    <p class="text-sm font-semibold text-gray-800">Đổi trả &amp; hoàn tiền</p>
                    <p class="mt-2 text-sm text-gray-600">Trường hợp áp dụng, quy trình xử lý và thời gian hoàn tiền.</p>
                </a>
            </div>
        </div>
    </section>
@endsection
