<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-lux-text">Email</label>
            <input id="email" class="block mt-1 w-full bg-lux-bg border border-white/10 text-lux-text rounded-xl focus:border-lux-gold focus:ring focus:ring-lux-gold/20" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block font-medium text-sm text-lux-text">Mật khẩu mới</label>
            <input id="password" class="block mt-1 w-full bg-lux-bg border border-white/10 text-lux-text rounded-xl focus:border-lux-gold focus:ring focus:ring-lux-gold/20" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <label for="password_confirmation" class="block font-medium text-sm text-lux-text">Xác nhận mật khẩu mới</label>
            <input id="password_confirmation" class="block mt-1 w-full bg-lux-bg border border-white/10 text-lux-text rounded-xl focus:border-lux-gold focus:ring focus:ring-lux-gold/20" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center mt-8">
            <button type="submit" class="w-full rounded-full bg-lux-gold px-4 py-3 text-sm font-semibold text-lux-bg shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                Cập nhật mật khẩu mới
            </button>
        </div>
    </form>
</x-guest-layout>
