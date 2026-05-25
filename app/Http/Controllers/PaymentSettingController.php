<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSettingController extends Controller
{
    public function edit(): View
    {
        $setting = PaymentSetting::getActive() ?? new PaymentSetting();
        $banks = PaymentSetting::bankList();

        return view('admin.payment-settings.edit', compact('setting', 'banks'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_id'        => 'required|string|max:20',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
        ]);

        $banks = PaymentSetting::bankList();

        if (! isset($banks[$validated['bank_id']])) {
            return back()->withErrors(['bank_id' => 'Ngân hàng không hợp lệ.'])->withInput();
        }

        $validated['bank_name'] = $banks[$validated['bank_id']];
        $validated['is_active'] = true;

        // Deactivate all existing settings
        PaymentSetting::query()->update(['is_active' => false]);

        // Create or update active setting
        $setting = PaymentSetting::getActive();
        if ($setting) {
            $setting->update($validated);
        } else {
            PaymentSetting::create($validated);
        }

        return redirect()
            ->route('admin.payment-settings.edit')
            ->with('success', 'Cập nhật thông tin thanh toán thành công.');
    }
}
