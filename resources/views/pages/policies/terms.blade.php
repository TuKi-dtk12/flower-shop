@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-4xl space-y-6 text-gray-700">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-400">Điều khoản dịch vụ</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Mua sắm an tâm</h1>
            </div>

            <div class="space-y-4 text-sm text-gray-600">
                <ul class="list-disc space-y-2 pl-5">
                    <li>Mọi đơn hàng phụ thuộc vào tình trạng hoa và xác nhận.</li>
                    <li>Giá đã bao gồm gói tiêu chuẩn và hiển thị theo VND.</li>
                    <li>Yêu cầu tùy chỉnh có thể cần xác nhận thêm và phát sinh phí.</li>
                    <li>Chúng tôi có thể thay thế hoa khi nguồn cung theo mùa thay đổi.</li>
                </ul>
                <p>Khi đặt hàng, bạn đồng ý với điều khoản này và các chính sách liên quan.</p>
            </div>
        </div>
    </section>
@endsection
