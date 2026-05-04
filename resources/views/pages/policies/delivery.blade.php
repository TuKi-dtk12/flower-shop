@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-4xl space-y-6 text-gray-700">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-400">Chính sách giao hàng</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Giao đúng hẹn, trao tận tay</h1>
            </div>

            <div class="space-y-4 text-sm text-gray-600">
                <ul class="list-disc space-y-2 pl-5">
                    <li>Giao trong ngày cho đơn đặt trước 14:00.</li>
                    <li>Khung giờ giao tiêu chuẩn: 9:00 - 12:00, 13:00 - 17:00, 18:00 - 21:00.</li>
                    <li>Phạm vi nội thành TPHCM. Khu vực xa có thể phát sinh phí.</li>
                    <li>Cập nhật giao hàng qua SMS hoặc email.</li>
                </ul>
                <p>Liên hệ để sắp xếp giao đặc biệt, sự kiện hoặc đơn doanh nghiệp.</p>
            </div>
        </div>
    </section>
@endsection
