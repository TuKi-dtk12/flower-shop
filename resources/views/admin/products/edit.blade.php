@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Admin - Edit Product</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-700">
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
            <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Product name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Price (VND)</label>
            <input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">New main image (jpeg/png, max 2MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Add gallery images</label>
            <input type="file" name="images[]" multiple accept="image/jpeg,image/png" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" id="clear-gallery" name="clear_gallery" value="1" class="h-4 w-4 rounded border-gray-300 text-rose-500 focus:ring-rose-200">
            <label for="clear-gallery">Clear existing gallery before adding new images</label>
        </div>

        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">Save changes</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Back</a>
        </div>
    </form>
</div>
@endsection
