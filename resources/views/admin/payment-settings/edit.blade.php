@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-2xl animate-fade-in-up">
    <div class="rounded-3xl border border-white/5 bg-lux-card p-6 shadow-sm sm:p-8">
        <div class="mb-6">
            <h1 class="font-serif text-3xl font-semibold text-lux-gold">Cài đặt thanh toán</h1>
            <p class="mt-1 text-sm text-lux-text/60">Cấu hình tài khoản ngân hàng để nhận thanh toán qua VietQR.</p>
        </div>

        <form method="POST" action="{{ route('admin.payment-settings.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Bank Select --}}
            <div>
                <label for="bank_id" class="mb-1.5 block text-sm font-semibold text-lux-text/70">Ngân hàng</label>
                <select name="bank_id" id="bank_id" required
                    class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text shadow-sm transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                    <option value="">-- Chọn ngân hàng --</option>
                    @foreach ($banks as $binCode => $bankName)
                        <option value="{{ $binCode }}" {{ old('bank_id', $setting->bank_id) === (string) $binCode ? 'selected' : '' }}>{{ $bankName }} ({{ $binCode }})</option>
                    @endforeach
                </select>
                @error('bank_id')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Account Number --}}
            <div>
                <label for="account_number" class="mb-1.5 block text-sm font-semibold text-lux-text/70">Số tài khoản</label>
                <input type="text" name="account_number" id="account_number"
                    value="{{ old('account_number', $setting->account_number) }}"
                    placeholder="Ví dụ: 1234567890"
                    required
                    class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text placeholder-lux-text/40 shadow-sm transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                @error('account_number')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Account Name --}}
            <div>
                <label for="account_name" class="mb-1.5 block text-sm font-semibold text-lux-text/70">Tên chủ tài khoản</label>
                <input type="text" name="account_name" id="account_name"
                    value="{{ old('account_name', $setting->account_name) }}"
                    placeholder="Ví dụ: NGUYEN VAN A"
                    required
                    class="w-full rounded-xl border border-white/10 bg-lux-bg px-4 py-2.5 text-sm text-lux-text placeholder-lux-text/40 shadow-sm transition focus:border-lux-gold focus:outline-none focus:ring-1 focus:ring-lux-gold/40">
                @error('account_name')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- QR Preview --}}
            @if($setting->bank_id && $setting->account_number)
                <div class="rounded-2xl border border-lux-gold/20 bg-lux-gold/5 p-5">
                    <p class="mb-3 text-sm font-semibold text-lux-gold">🔍 Xem trước mã QR mẫu</p>
                    <div class="flex justify-center">
                        <div class="overflow-hidden rounded-xl border-2 border-lux-gold/30 bg-white p-2 shadow-lg shadow-lux-gold/5">
                            <img src="https://img.vietqr.io/image/{{ $setting->bank_id }}-{{ $setting->account_number }}-compact2.jpg?amount=100000&addInfo=TUKI+PREVIEW&accountName={{ urlencode($setting->account_name) }}"
                                alt="QR Preview" class="h-48 w-48 object-contain" loading="lazy">
                        </div>
                    </div>
                    <p class="mt-2 text-center text-xs text-lux-text/50">Mẫu QR với số tiền 100,000 VND</p>
                </div>
            @endif

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="rounded-xl bg-lux-gold px-6 py-2.5 text-sm font-semibold text-lux-bg shadow-md transition hover:shadow-lg active:scale-[0.98]">
                    Lưu cài đặt
                </button>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-lux-text/50 transition hover:text-lux-gold">Quay lại</a>
            </div>
        </form>
    </div>
</section>
@endsection
