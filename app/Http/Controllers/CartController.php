<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        if (Auth::check()) {
            $dbItems = Auth::user()->cartItems()->with('product')->get();
            $cart = [];
            foreach ($dbItems as $item) {
                if ($item->product) {
                    $cart[$item->product_id] = [
                        'product_id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => (float) $item->product->price,
                        'quantity' => $item->quantity,
                        'image' => $item->product->image,
                    ];
                }
            }
        } else {
            $cart = session()->get('cart', []);
        }

        $total = collect($cart)->sum(fn (array $item) => $item['price'] * $item['quantity']);

        return view('cart', compact('cart', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        if (Auth::check()) {
            $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();
            
            if ($cartItem) {
                $newQuantity = min(50, $cartItem->quantity + $validated['quantity']);
                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                Auth::user()->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => min(50, $validated['quantity']),
                ]);
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = min(50, $cart[$product->id]['quantity'] + $validated['quantity']);
            } else {
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'quantity' => min(50, $validated['quantity']),
                    'image' => $product->image,
                ];
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        if (Auth::check()) {
            $cartItem = Auth::user()->cartItems()->where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->update(['quantity' => min(50, $validated['quantity'])]);
            } else {
                return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
            }
        } else {
            $cart = session()->get('cart', []);

            if (! isset($cart[$product->id])) {
                return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
            }

            $cart[$product->id]['quantity'] = min(50, $validated['quantity']);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->where('product_id', $product->id)->delete();
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                unset($cart[$product->id]);
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
