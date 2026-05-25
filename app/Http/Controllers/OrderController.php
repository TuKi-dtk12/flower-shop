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
        $validated = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_email'   => 'required|email|max:255',
            'shipping_address' => 'required|string|max:1000',
            'note'             => 'nullable|string|max:500',
            'payment_method'   => 'required|in:cod,bank_transfer',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống.');
        }

        $order = null;

        DB::transaction(function () use ($request, $cart, $validated, &$order): void {
            $totalPrice = collect($cart)
                ->sum(fn (array $item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id'          => $request->user()->id,
                'total_price'      => $totalPrice,
                'status'           => 'pending',
                'shipping_name'    => $validated['shipping_name'],
                'shipping_phone'   => $validated['shipping_phone'],
                'shipping_email'   => $validated['shipping_email'],
                'shipping_address' => $validated['shipping_address'],
                'note'             => $validated['note'] ?? null,
                'payment_method'   => $validated['payment_method'],
                'payment_status'   => 'pending',
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }
        });

        session()->forget('cart');

        if ($validated['payment_method'] === 'bank_transfer' && $order) {
            return redirect()->route('payment.show', $order);
        }

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    /**
     * Admin confirms or rejects payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed',
        ]);

        $order->update(['payment_status' => $validated['payment_status']]);

        return back()->with('success', 'Cập nhật trạng thái thanh toán đơn hàng #' . $order->id . ' thành công.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return back()->with('success', 'Xóa đơn hàng thành công.');
    }
}
