<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'images' => ['nullable', 'array', 'max:3'], // Max 3 images
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'], // Explicit MIME validation, 3MB limit
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Generate a cryptographically secure, unpredictable filename
                $secureName = Str::uuid()->toString() . '_' . time() . '.' . $file->extension();
                
                try {
                    // Use Laravel's native upload engine to stream the file safely
                    $path = $file->storeAs('review_attachments', $secureName, 'public');

                    // Create DB record
                    $review->images()->create([
                        'image_path' => $path,
                    ]);
                } catch (\Exception $e) {
                    // Log error and ignore this file if malicious or unreadable
                    \Illuminate\Support\Facades\Log::warning("Failed to process review image upload: " . $e->getMessage());
                }
            }
        }

        return redirect()->route('products.show', $product->slug ?? $product->id)->with('success', 'Đánh giá của bạn đã được gửi thành công.');
    }
}
