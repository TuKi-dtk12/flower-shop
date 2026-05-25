@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-rose-100 bg-white/80 p-8 shadow-sm">
        <div class="mx-auto max-w-4xl space-y-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-400">Nhật ký Tuki Fresh Flower</p>
                <h1 class="mt-2 font-serif text-3xl font-semibold text-rose-600">Câu chuyện, mẹo chăm hoa và cảm hứng</h1>
                <p class="mt-2 text-sm text-gray-600">Bài viết mới sẽ sớm xuất hiện. Tạm thời, hãy xem các chủ đề nổi bật.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl border border-rose-100 bg-rose-50/40 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Hướng dẫn</p>
                    <h2 class="mt-2 text-sm font-semibold text-gray-800">Cách chọn hoa theo dịp</h2>
                    <p class="mt-2 text-sm text-gray-600">Gợi ý nhanh để chọn hoa đúng cảm xúc.</p>
                </article>
                <article class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Chăm sóc</p>
                    <h2 class="mt-2 text-sm font-semibold text-gray-800">Giữ hoa tươi lâu hơn</h2>
                    <p class="mt-2 text-sm text-gray-600">Những bước đơn giản giúp kéo dài tuổi thọ bó hoa.</p>
                </article>
                <article class="rounded-2xl border border-rose-100 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Xu hướng</p>
                    <h2 class="mt-2 text-sm font-semibold text-gray-800">Bảng màu sang mềm cho 2026</h2>
                    <p class="mt-2 text-sm text-gray-600">Khám phá sắc hồng phấn, xanh sage và kem trong thiết kế hiện đại.</p>
                </article>
            </div>
        </div>
    </section>
@endsection
