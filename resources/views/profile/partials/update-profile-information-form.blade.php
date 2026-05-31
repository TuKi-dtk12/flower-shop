<section>
    <header>
        <h2 class="text-xl font-medium text-lux-gold">
            Thông tin cá nhân
        </h2>

        <p class="mt-1 text-sm text-lux-text/70">
            Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Upload -->
        <div>
            <label for="avatar" class="block font-medium text-sm text-lux-text">Ảnh đại diện</label>
            @if ($user->avatar)
                <div class="mt-2 mb-4">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="h-20 w-20 rounded-full object-cover border-2 border-lux-gold">
                </div>
            @endif
            <input id="avatar" name="avatar" type="file" accept="image/jpeg, image/png, image/webp" class="mt-1 block w-full text-sm text-lux-text/70 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lux-gold/10 file:text-lux-gold hover:file:bg-lux-gold/20 focus:outline-none" />
            @error('avatar')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name" class="block font-medium text-sm text-lux-text">Họ và tên</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-lux-gold focus:ring focus:ring-lux-gold/20" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-lux-text">Địa chỉ Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-lux-gold focus:ring focus:ring-lux-gold/20" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-lux-text/70">
                        Email của bạn chưa được xác minh.

                        <button form="send-verification" class="underline text-sm text-lux-gold hover:text-lux-gold/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lux-gold focus:ring-offset-lux-bg">
                            Nhấn vào đây để gửi lại email xác minh.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-lux-gold text-lux-bg font-semibold rounded-xl px-5 py-2.5 transition shadow-md hover:shadow-lg hover:-translate-y-0.5">
                Lưu thay đổi
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-lux-gold"
                >Đã lưu thành công.</p>
            @endif
        </div>
    </form>
</section>
