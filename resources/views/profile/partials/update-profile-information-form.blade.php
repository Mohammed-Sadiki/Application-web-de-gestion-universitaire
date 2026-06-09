<section>
    <header class="flex justify-between items-center mb-8 relative">
        <h2 style="color: #1e1b4b !important; font-weight: 800 !important; font-size: 1.35rem !important; display: flex; align-items: center; gap: 8px;">
            {{ __('app.profile_info') ?? 'معلومات الملف الشخصي' }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name">{{ __('app.full_name') ?? 'الاسم الكامل' }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2 text-[#d946ef] text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email">{{ __('app.email_address') ?? 'البريد الإلكتروني' }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
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

        <div class="flex items-center gap-4 pt-4 justify-start">
            <button type="submit">
                {{ __('app.save') ?? 'حفظ' }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-green-600 font-medium">
                    {{ __('app.saved') ?? 'تم الحفظ' }}
                </p>
            @endif
        </div>
    </form>
</section>
