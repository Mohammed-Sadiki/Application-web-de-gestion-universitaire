<section class="space-y-6">
    <header class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full"></span>
            {{ __('app.delete_account') }}
        </h2>
    </header>

    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
        <p class="text-xs text-red-400 font-medium leading-relaxed">
            {{ __('app.delete_account_warning') }}
        </p>
    </div>

    <div class="flex justify-end">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-500 px-6 py-2.5 rounded-xl text-xs font-bold transition">
            {{ __('app.delete_account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-white mb-3">
                {{ __('app.delete_account_confirm') }}
            </h2>

            <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                {{ __('app.delete_account_irreversible') }}
            </p>

            <div>
                <label for="password" class="sr-only">{{ __('app.password') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('app.your_password') }}"
                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 transition text-right">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[#d946ef] text-xs" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl text-xs font-bold text-gray-400 hover:text-white transition">
                    {{ __('app.cancel') }}
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-lg shadow-red-900/30 transition">
                    {{ __('app.delete_permanently') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
