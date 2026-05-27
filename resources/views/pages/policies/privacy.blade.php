@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-4xl space-y-6 text-gray-700">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-400">Chính sách bảo mật</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Dữ liệu của bạn, được bảo vệ cẩn trọng</h1>
            </div>

            <div class="space-y-4 text-sm text-gray-600">
                <p>Chúng tôi chỉ thu thập thông tin cần thiết để xử lý đơn hàng và cải thiện trải nghiệm mua sắm.</p>
                <ul class="list-disc space-y-2 pl-5">
                    <li>Thông tin liên hệ để xác nhận giao hàng và cập nhật đơn.</li>
                    <li>Thông tin thanh toán được xử lý an toàn bởi nhà cung cấp uy tín.</li>
                    <li>Dữ liệu duyệt web để cá nhân hóa gợi ý và ưu đãi.</li>
                </ul>
                <p>Chúng tôi không bán dữ liệu của bạn. Việc truy cập chỉ dành cho nhân sự được ủy quyền và đối tác tuân thủ.</p>
                <p>Nếu có yêu cầu về quyền riêng tư, vui lòng liên hệ vào email: tuankiet121305@gmail.com</p>
            </div>
        </div>
    </section>
@endsection
