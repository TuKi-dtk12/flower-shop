<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        return redirect()->route('products.show', $product->slug ?? $product->id)->with('success', 'Đánh giá của bạn đã được gửi thành công.');
    }
}
