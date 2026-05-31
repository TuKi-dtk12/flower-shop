<section>
    <header>
        <h2 class="text-xl font-medium text-lux-gold">
            Cập nhật mật khẩu
        </h2>

        <p class="mt-1 text-sm text-lux-text/70">
            Đảm bảo tài khoản của bạn đang sử dụng mật khẩu dài và ngẫu nhiên để tối ưu hóa bảo mật.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-lux-text">Mật khẩu hiện tại</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-lux-gold focus:ring focus:ring-lux-gold/20" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-lux-text">Mật khẩu mới</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-lux-gold focus:ring focus:ring-lux-gold/20" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-lux-text">Xác nhận mật khẩu mới</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-lux-gold focus:ring focus:ring-lux-gold/20" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-lux-gold text-lux-bg font-semibold rounded-xl px-5 py-2.5 transition shadow-md hover:shadow-lg hover:-translate-y-0.5">
                Lưu thay đổi
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-lux-gold"
                >Đã cập nhật mật khẩu.</p>
            @endif
        </div>
    </form>
</section>
