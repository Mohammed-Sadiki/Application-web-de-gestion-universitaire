<section>
    <header class="flex justify-between items-center mb-8">
        <h2 style="color: #1e1b4b !important; font-weight: 800 !important; font-size: 1.35rem !important; display: flex; align-items: center; gap: 8px;">
            {{ __('app.edit_password') ?? 'تغيير كلمة المرور' }}
        </h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password">{{ __('app.current_password') ?? 'كلمة المرور الحالية' }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div>
            <label for="update_password_password">{{ __('app.new_password') ?? 'كلمة المرور الجديدة' }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div>
            <label for="update_password_password_confirmation">{{ __('app.confirm_password') ?? 'تأكيد كلمة المرور' }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-4 justify-start">
            <button type="submit">
                {{ __('app.save') ?? 'حفظ' }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-green-600 font-medium">
                    {{ __('app.saved') ?? 'تم الحفظ' }}
                </p>
            @endif
        </div>
    </form>
</section>
