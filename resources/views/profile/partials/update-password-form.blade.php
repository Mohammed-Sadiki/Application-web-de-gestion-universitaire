<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" autocomplete="current-password" />
            @error('current_password', 'updatePassword') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" autocomplete="new-password" />
            @error('password', 'updatePassword') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Confirmer le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                Enregistrer
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-green-400 font-bold"
                >Enregistré.</p>
            @endif
        </div>
    </form>
</section>
