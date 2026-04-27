@extends('layouts.app')

@section('content')
<div class="rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Admin - Product Management</h1>
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">+ New Product</a>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-rose-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Image</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Price</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3"><img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/120x90?text=Flower' }}" alt="{{ $product->name }}" class="h-14 w-20 rounded-lg object-cover"></td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-rose-600">{{ number_format($product->price, 0, ',', '.') }} VND</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
</div>
@endsection
