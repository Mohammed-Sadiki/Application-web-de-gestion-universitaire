<section>
    <div class="border border-[#d946ef]/20 bg-[#d946ef]/5 rounded-2xl p-6">
        <h3 class="text-base font-bold text-[#d946ef] mb-1 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            {{ __('Supprimer le Compte') }}
        </h3>
        <p class="text-sm text-gray-400">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.') }}
        </p>
    </div>

    <div class="mt-4">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="!bg-[#d946ef]/10 !border !border-[#d946ef]/30 !text-[#d946ef] hover:!bg-[#d946ef]/20 !font-bold !rounded-xl !text-xs !px-4 !py-2 !shadow-none"
        >{{ __('Supprimer le compte') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-7">
            @csrf
            @method('delete')

            <div class="flex items-start gap-4 mb-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#d946ef]/10 border border-[#d946ef]/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#d946ef]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-white">
                        {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-400">
                        {{ __('Cette action est irréversible. Veuillez saisir votre mot de passe pour confirmer.') }}
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 sr-only">{{ __('Mot de passe') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#d946ef] transition"
                    placeholder="{{ __('Votre mot de passe') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[#d946ef] text-xs" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                    {{ __('Annuler') }}
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/30 text-[#d946ef] text-xs font-bold rounded-xl transition">
                    {{ __('Supprimer définitivement') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
