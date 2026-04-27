@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-3xl border border-rose-100 bg-white p-6 shadow-sm">
    <h1 class="font-['Playfair_Display'] text-3xl font-semibold text-gray-900">Admin - Edit Category</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-6 space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Category name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-rose-400 focus:outline-none" placeholder="Birthday Flowers">
        </div>

        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">Save changes</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Back</a>
        </div>
    </form>
</div>
@endsection
