@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm">
    <h1 class="font-serif text-3xl font-semibold text-lux-gold">Chỉnh sửa sản phẩm</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Danh mục</label>
            <select name="category_id" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Giá (VND)</label>
            <input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" required class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Mô tả</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-lux-text placeholder-lux-text/40 transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Ảnh chính mới (jpeg/png, tối đa 2MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text/70 file:mr-3 file:rounded-lg file:border-0 file:bg-lux-gold/10 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-lux-gold">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-lux-text/70">Thêm ảnh bộ sưu tập</label>
            <input type="file" name="images[]" multiple accept="image/jpeg,image/png" class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text/70 file:mr-3 file:rounded-lg file:border-0 file:bg-lux-gold/10 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-lux-gold">
        </div>

        <div class="flex items-center gap-2 text-sm text-lux-text/60">
            <input type="checkbox" id="clear-gallery" name="clear_gallery" value="1" class="h-4 w-4 rounded border-white/20 bg-lux-bg text-lux-gold focus:ring-lux-gold/30">
            <label for="clear-gallery">Xóa bộ sưu tập cũ trước khi thêm ảnh mới</label>
        </div>

        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="rounded-lg bg-lux-gold px-5 py-2.5 text-sm font-semibold text-lux-bg transition hover:shadow-lg active:scale-[0.98]">Lưu thay đổi</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-white/10 px-5 py-2.5 text-sm font-semibold text-lux-text/70 transition hover:bg-white/5">Quay lại</a>
        </div>
    </form>
</div>
@endsection
