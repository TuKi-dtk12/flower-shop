<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png|max:2048',
            'clear_gallery' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }
                $path = $file->store('products/gallery', 'public');
                $path = $this->sanitizeStoragePath($path);
                if ($path === '') {
                    continue;
                }
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png|max:2048',
            'clear_gallery' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                $path = $this->sanitizeStoragePath($product->image);
                if ($path !== '') {
                    Storage::disk('public')->delete($path);
                }
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->boolean('clear_gallery')) {
            $product->load('images');
            foreach ($product->images as $image) {
                $path = $this->sanitizeStoragePath($image->image_path);
                if ($path !== '') {
                    Storage::disk('public')->delete($path);
                }
            }
            $product->images()->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }
                $path = $file->store('products/gallery', 'public');
                $path = $this->sanitizeStoragePath($path);
                if ($path === '') {
                    continue;
                }
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            $path = $this->sanitizeStoragePath($product->image);
            if ($path !== '') {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($product->images as $image) {
            $path = $this->sanitizeStoragePath($image->image_path);
            if ($path !== '') {
                Storage::disk('public')->delete($path);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function sanitizeStoragePath(?string $path): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return '';
        }

        $path = str_replace(['..', '\\'], '', $path);

        return ltrim($path, '/');
    }
}
