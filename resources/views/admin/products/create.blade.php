@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
    <h1 class="font-serif text-3xl font-semibold text-lux-gold">Tạo sản phẩm mới</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Danh mục</label>
            <select name="category_id" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) old('category_id') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Giá (VND)</label>
            <input type="number" name="price" min="0" step="0.01" value="{{ old('price') }}" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Mô tả</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Ảnh chính (jpeg/png, tối đa 2MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text/70 file:mr-3 file:rounded-lg file:border-0 file:bg-lux-gold/10 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-lux-gold">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Ảnh bộ sưu tập</label>
            <input type="file" name="images[]" multiple accept="image/jpeg,image/png" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text/70 file:mr-3 file:rounded-lg file:border-0 file:bg-lux-gold/10 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-lux-gold">
        </div>

        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg transition hover:shadow-lg active:scale-[0.98]">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-white/10 px-5 py-2.5 text-sm font-semibold text-lux-text/70 transition hover:bg-white/5">Quay lại</a>
        </div>
    </form>
</div>
@endsection
