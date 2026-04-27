<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'items.product'])->latest();

        if (! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);

            $orders = $query->paginate(10)->withQueryString();

            return view('orders.index', compact('orders'));
        }

        $filters = $request->validate([
            'q' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,completed,cancelled',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query
            ->when($filters['q'] ?? null, function ($builder, $term) {
                $builder->where(function ($subQuery) use ($term) {
                    if (is_numeric($term)) {
                        $subQuery->orWhere('id', (int) $term);
                    }

                    $subQuery->orWhereHas('user', function ($userQuery) use ($term) {
                        $userQuery->where('name', 'like', '%' . $term . '%');
                    });
                });
            })
            ->when($filters['status'] ?? null, fn ($builder, $status) => $builder->where('status', $status))
            ->when($filters['date_from'] ?? null, fn ($builder, $dateFrom) => $builder->whereDate('created_at', '>=', $dateFrom))
            ->when($filters['date_to'] ?? null, fn ($builder, $dateTo) => $builder->whereDate('created_at', '<=', $dateTo));

        $orders = $query->paginate(10)->withQueryString();

        if ($request->user()->is_admin) {
            return view('admin.orders.index', compact('orders'));
        }

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($request, $cart): void {
            $totalPrice = collect($cart)
                ->sum(fn (array $item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }
}
