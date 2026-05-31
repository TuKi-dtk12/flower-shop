<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Save the guest cart before authentication
        $guestCart = session()->get('cart', []);

        $request->authenticate();

        $request->session()->regenerate();

        // Merge guest cart into database cart
        if (!empty($guestCart)) {
            $user = Auth::user();
            foreach ($guestCart as $productId => $item) {
                $cartItem = $user->cartItems()->where('product_id', $productId)->first();
                if ($cartItem) {
                    $newQuantity = min(50, $cartItem->quantity + $item['quantity']);
                    $cartItem->update(['quantity' => $newQuantity]);
                } else {
                    $user->cartItems()->create([
                        'product_id' => $productId,
                        'quantity' => min(50, $item['quantity']),
                    ]);
                }
            }
            // Clear the guest cart from session
            session()->forget('cart');
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
