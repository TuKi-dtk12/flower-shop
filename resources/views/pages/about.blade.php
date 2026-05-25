@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-3xl space-y-6 text-gray-700">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-400">Giới thiệu Tuki Fresh Flower</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Xưởng hoa cho quà tặng hiện đại</h1>
                <p class="mt-3 text-base text-gray-600">
                    Tuki Fresh Flower tuyển chọn các bó hoa theo mùa với câu chuyện màu sắc tinh tế, gói ghém trang nhã và cảm giác cao cấp
                    nhẹ nhàng. Chúng tôi thiết kế cho sinh nhật, cưới hỏi, kỷ niệm và mọi khoảnh khắc ý nghĩa.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-4">
                    <p class="text-sm font-semibold text-emerald-700">Cam kết</p>
                    <p class="mt-2 text-sm text-gray-600">Hoa tươi mỗi ngày, được chọn thủ công và giao tận tay.</p>
                </div>
                <div class="rounded-2xl border border-rose-100 bg-rose-50/40 p-4">
                    <p class="text-sm font-semibold text-rose-600">Phong cách</p>
                    <p class="mt-2 text-sm text-gray-600">Bảng màu thanh lịch, chất liệu hiện đại, chi tiết mềm mại.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-rose-100 bg-white p-4">
                <p class="text-sm font-semibold text-gray-800">Liên hệ</p>
                <div class="mt-2 space-y-1 text-sm text-gray-600">
                    <p>Địa chỉ: 72/34 Dương Đức Hiền, Tây Thạnh, TPHCM</p>
                    <p>Điện thoại: 0866384257</p>
                    <p>Email: support@freshflower.vn</p>
                </div>
            </div>
        </div>
    </section>
@endsection
