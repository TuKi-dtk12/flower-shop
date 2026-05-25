@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
    <h1 class="font-serif text-3xl font-semibold text-lux-gold">Tạo danh mục mới</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Tên danh mục</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40" placeholder="Hoa sinh nhật">
        </div>

        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg transition hover:shadow-lg active:scale-[0.98]">Lưu danh mục</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-white/10 px-5 py-2.5 text-sm font-semibold text-lux-text/70 transition hover:bg-white/5">Quay lại</a>
        </div>
    </form>
</div>
@endsection
