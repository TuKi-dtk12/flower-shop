@extends('layouts.app')

@section('content')
<section class="rounded-3xl border border-gray-200 bg-gray-50/80 p-5 shadow-sm sm:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-gray-900">Admin Category Management</h1>
            <p class="mt-1 text-sm text-gray-600">Keep your floral catalog taxonomy clean and discoverable.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">+ New Category</a>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($categories as $category)
            <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-xl sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-gray-500">Category #{{ $category->id }}</p>
                        <h2 class="mt-1 text-lg font-semibold text-gray-900">{{ $category->name }}</h2>
                        <p class="mt-1 text-sm text-gray-600">Created: {{ $category->created_at?->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex flex-wrap justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg border border-emerald-300 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-50">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-rose-300 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">No categories found.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $categories->links() }}</div>
</section>
@endsection
