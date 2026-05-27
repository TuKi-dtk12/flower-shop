<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Instead of creating the user immediately, generate a 6-digit OTP,
     * store the registration data in cache (5 min TTL), send the OTP
     * via email, and redirect to the verification page.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->symbols(),
            ],
        ], [
            'name.required'       => 'Vui lòng nhập họ và tên.',
            'email.required'      => 'Vui lòng nhập địa chỉ email.',
            'email.email'         => 'Địa chỉ email không hợp lệ.',
            'email.unique'        => 'Email này đã được sử dụng.',
            'password.required'   => 'Vui lòng nhập mật khẩu.',
            'password.confirmed'  => 'Xác nhận mật khẩu không khớp.',
            'password.min'        => 'Mật khẩu phải có độ dài tối thiểu :min ký tự.',
        ]);

        // Generate a 6-digit OTP
        $otp = (string) rand(100000, 999999);

        // Store registration data + OTP in cache (expires in 5 minutes)
        Cache::put('otp_registration_' . $request->email, [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // Will be hashed when user is actually created
            'otp'      => $otp,
        ], now()->addMinutes(5));

        // Send OTP email
        Mail::to($request->email)->send(new OtpVerificationMail($otp));

        return redirect()->route('verify-otp.show', ['email' => $request->email]);
    }
}
