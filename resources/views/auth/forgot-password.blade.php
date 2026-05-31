<x-guest-layout>
    <div class="mb-6 text-sm text-lux-text/70 leading-relaxed text-center">
        Quên mật khẩu? Không sao cả. Hãy cung cấp địa chỉ email của bạn, chúng tôi sẽ gửi một liên kết đặt lại mật khẩu qua email để bạn lựa chọn mật khẩu mới.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-400 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-lux-text">Địa chỉ Email</label>
            <input id="email" class="block mt-1 w-full bg-lux-bg border border-white/10 text-lux-text rounded-xl focus:border-lux-gold focus:ring focus:ring-lux-gold/20" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center mt-8">
            <button type="submit" class="w-full rounded-full bg-lux-gold px-4 py-3 text-sm font-semibold text-lux-bg shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                Gửi liên kết đặt lại mật khẩu
            </button>
        </div>
    </form>
</x-guest-layout>
