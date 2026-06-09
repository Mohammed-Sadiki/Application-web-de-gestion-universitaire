<section>
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full"></span>
            {{ __('app.edit_password') }}
        </h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.current_password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#06b6d4] transition text-right">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.new_password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#06b6d4] transition text-right">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.confirm_password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#06b6d4] transition text-right">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-4 justify-end">
            <button type="submit" class="bg-gradient-to-r from-[#06b6d4] to-[#3b82f6] text-white px-8 py-3 rounded-xl text-xs font-bold shadow-lg shadow-cyan-900/30 transition hover:opacity-90 transform hover:-translate-y-0.5">
                {{ __('app.save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-green-400 font-medium">
                    {{ __('app.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
