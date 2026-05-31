<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $featuredProducts = Schema::hasTable('products')
        ? Product::with('category')->latest()->take(8)->get()
        : collect();

    return view('home', compact('featuredProducts'));
})->name('home');

Route::get('/products', function () {
    $categoryId = request('category');
    $search = trim(strip_tags((string) request('search')));

    $products = Product::with('category')
        ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
        ->when($search, fn ($query, $term) => $query->where('name', 'like', '%' . $term . '%'))
        ->latest()
        ->paginate(12)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    return view('products.index', compact('products', 'categories', 'categoryId', 'search'));
})->name('products.index');

Route::get('/products/{product}', function (Product $product) {
    $product->load(['category', 'images']);

    return view('products.show', compact('product'));
})->name('products.show');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::prefix('policies')->name('policies.')->group(function () {
    Route::get('/', function () {
        return view('pages.policies.index');
    })->name('index');

    Route::get('/privacy', function () {
        return view('pages.policies.privacy');
    })->name('privacy');

    Route::get('/delivery', function () {
        return view('pages.policies.delivery');
    })->name('delivery');

    Route::get('/terms', function () {
        return view('pages.policies.terms');
    })->name('terms');

    Route::get('/return-refund', function () {
        return view('pages.policies.refund');
    })->name('refund');
});

Route::post('/chat/consult', [ChatController::class, 'consult'])
    ->middleware('throttle:30,1')
    ->name('chat.consult');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', function () {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn (array $item) => $item['price'] * $item['quantity']);

        return view('checkout', compact('cart', 'total'));
    })->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // Payment routes
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/orders/{order}/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::patch('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Payment settings
        Route::get('/payment-settings', [PaymentSettingController::class, 'edit'])->name('payment-settings.edit');
        Route::put('/payment-settings', [PaymentSettingController::class, 'update'])->name('payment-settings.update');
    });

require __DIR__.'/auth.php';
