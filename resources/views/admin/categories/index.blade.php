@extends('layouts.app')

@section('content')
<section class="rounded-3xl border border-white/5 bg-lux-card p-5 shadow-sm sm:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-lux-gold">Quản lý danh mục</h1>
            <p class="mt-1 text-sm text-lux-text/60">Tổ chức danh mục hoa sạch sẽ và dễ tìm kiếm.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="rounded-xl bg-lux-gold px-4 py-2 text-sm font-semibold text-lux-bg shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">+ Thêm danh mục</a>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($categories as $category)
            <article class="rounded-2xl border border-white/5 bg-lux-bg p-4 shadow-sm transition hover:border-lux-gold/20 hover:shadow-xl sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-lux-text/50">Danh mục #{{ $category->id }}</p>
                        <h2 class="mt-1 text-lg font-semibold text-lux-text">{{ $category->name }}</h2>
                        <p class="mt-1 text-sm text-lux-text/60">Ngày tạo: {{ $category->created_at?->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex flex-wrap justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg border border-lux-gold/40 px-3 py-2 text-xs font-semibold text-lux-gold transition hover:bg-lux-gold/10">Sửa</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Xóa danh mục này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-500/40 px-3 py-2 text-xs font-semibold text-red-400 transition hover:bg-red-500/10">Xóa</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-dashed border-white/10 bg-lux-bg p-8 text-center text-sm text-lux-text/50">Chưa có danh mục nào.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $categories->links() }}</div>
</section>
@endsection
