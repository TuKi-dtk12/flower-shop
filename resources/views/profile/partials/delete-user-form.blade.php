<section class="space-y-6">
    <header>
        <h2 class="text-xl font-medium text-red-500">
            Xóa tài khoản
        </h2>

        <p class="mt-1 text-sm text-lux-text/70">
            Một khi tài khoản đã bị xóa, toàn bộ dữ liệu sẽ không thể khôi phục. Trước khi xóa tài khoản, vui lòng tải xuống mọi dữ liệu hoặc thông tin mà bạn muốn giữ lại.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600/90 text-white font-semibold rounded-xl px-5 py-2.5 transition shadow-md hover:bg-red-600 hover:shadow-lg hover:-translate-y-0.5"
    >
        Xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-lux-card border border-white/10 rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                Bạn có chắc chắn muốn xóa tài khoản của mình không?
            </h2>

            <p class="mt-1 text-sm text-lux-text/70">
                Một khi tài khoản đã bị xóa, toàn bộ dữ liệu sẽ không thể khôi phục. Vui lòng nhập mật khẩu của bạn để xác nhận hành động này.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Mật khẩu hiện tại</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-lux-bg border border-white/10 rounded-xl text-lux-text focus:border-red-500 focus:ring focus:ring-red-500/20"
                    placeholder="Nhập mật khẩu của bạn"
                />

                @error('password', 'userDeletion')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-sm font-semibold text-lux-text bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition">
                    Hủy bỏ
                </button>

                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600/90 rounded-xl shadow-md hover:bg-red-600 hover:shadow-lg transition">
                    Xóa tài khoản
                </button>
            </div>
        </form>
    </x-modal>
</section>
