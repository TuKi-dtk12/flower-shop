<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class VerifyOtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $email = $request->query('email');

        if (! $email || ! Cache::has('otp_registration_' . $email)) {
            return redirect()->route('register')->with('error', 'Phiên đăng ký đã hết hạn. Vui lòng đăng ký lại.');
        }

        return view('auth.verify-otp', ['email' => $email]);
    }

    /**
     * Verify the submitted OTP code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $email = $request->input('email');
        $submittedOtp = $request->input('otp');
        $cacheKey = 'otp_registration_' . $email;
        $rateLimitKey = 'otp_attempts_' . $email;

        // ── Brute-force protection: max 3 wrong attempts ──
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            // Flush registration data to force re-register
            Cache::forget($cacheKey);
            RateLimiter::clear($rateLimitKey);

            return redirect()->route('register')->withErrors([
                'otp' => 'Bạn đã nhập sai quá 3 lần. Vui lòng đăng ký lại.',
            ]);
        }

        // ── Retrieve stored registration data ──
        $registrationData = Cache::get($cacheKey);

        if (! $registrationData) {
            return redirect()->route('register')->with('error', 'Mã xác thực đã hết hạn. Vui lòng đăng ký lại.');
        }

        // ── Verify OTP ──
        if ($submittedOtp !== $registrationData['otp']) {
            RateLimiter::hit($rateLimitKey, 300); // 5 min decay

            $remaining = 3 - RateLimiter::attempts($rateLimitKey);

            return back()->withInput()->withErrors([
                'otp' => "Mã xác thực không chính xác. Bạn còn {$remaining} lần thử.",
            ]);
        }

        // ── OTP valid → Create user ──
        $user = User::create([
            'name'              => $registrationData['name'],
            'email'             => $registrationData['email'],
            'password'          => Hash::make($registrationData['password']),
            'email_verified_at' => now(),
        ]);

        // Cleanup
        Cache::forget($cacheKey);
        RateLimiter::clear($rateLimitKey);

        // Login and redirect
        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công! Chào mừng bạn đến với Tuki Fresh Flower.');
    }
}
