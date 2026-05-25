<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Show the VietQR payment page for an order.
     */
    public function show(Request $request, Order $order): View
    {
        // IDOR protection: only the order owner can view
        abort_if($order->user_id !== $request->user()->id, 403, 'Bạn không có quyền xem đơn hàng này.');

        // Only show payment page for bank_transfer orders that are pending payment
        abort_if($order->payment_method !== 'bank_transfer', 404);
        abort_if($order->payment_status !== 'pending', 410, 'Đơn hàng này đã được xử lý thanh toán.');

        // Get active bank config
        $paymentSetting = PaymentSetting::getActive();
        abort_if(! $paymentSetting, 503, 'Hệ thống thanh toán chưa được cấu hình. Vui lòng liên hệ Admin.');

        // Build transfer content (unique per order)
        $transferContent = 'TUKI DH' . $order->id;

        // Build QR URL server-side (anti-tampering: amount from DB only)
        $qrUrl = sprintf(
            'https://img.vietqr.io/image/%s-%s-compact2.jpg?amount=%s&addInfo=%s&accountName=%s',
            $paymentSetting->bank_id,
            $paymentSetting->account_number,
            intval($order->total_price),
            urlencode($transferContent),
            urlencode($paymentSetting->account_name)
        );

        return view('orders.payment', compact(
            'order',
            'qrUrl',
            'paymentSetting',
            'transferContent'
        ));
    }

    /**
     * Customer confirms they have made the bank transfer.
     */
    public function confirm(Request $request, Order $order): RedirectResponse
    {
        // IDOR protection
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->payment_method !== 'bank_transfer', 404);
        abort_if($order->payment_status !== 'pending', 410);

        $order->update(['payment_status' => 'paid']);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Cảm ơn bạn! Đơn hàng #' . $order->id . ' đang chờ Admin xác nhận thanh toán.');
    }
}
