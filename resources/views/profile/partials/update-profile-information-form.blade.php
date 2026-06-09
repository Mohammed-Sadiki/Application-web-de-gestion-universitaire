<section>
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full"></span>
            {{ __('app.profile_info') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.full_name') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] transition text-right">
            <x-input-error class="mt-2 text-[#d946ef] text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.email_address') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] transition text-right">
            <x-input-error class="mt-2 text-[#d946ef] text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl">
                    <p class="text-xs text-yellow-500 font-medium">
                        {{ __('app.email_unverified') }}

                        <button form="send-verification" class="underline hover:text-yellow-400 transition ml-2">
                            {{ __('app.reverify_email') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs text-green-500 font-bold">
                            {{ __('app.verification_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 justify-end">
            <button type="submit" class="bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] text-white px-8 py-3 rounded-xl text-xs font-bold shadow-lg shadow-purple-900/30 transition hover:opacity-90 transform hover:-translate-y-0.5">
                {{ __('app.save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-green-400 font-medium">
                    {{ __('app.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
