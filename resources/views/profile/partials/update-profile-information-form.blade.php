<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nom complet</label>
            <input id="name" name="name" type="text" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Adresse Email</label>
            <input id="email" name="email" type="email" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        Votre adresse email n'est pas vérifiée.

                        <button form="send-verification" class="underline text-sm text-[#8b5cf6] hover:text-[#d946ef] transition focus:outline-none">
                            Cliquez ici pour renvoyer l'email de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                Enregistrer
            </button>

            @if (session('status') === 'profile-updated')
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
