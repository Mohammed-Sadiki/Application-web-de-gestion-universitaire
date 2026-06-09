<x-guest-layout>
    <!-- Logo -->
    <div class="mb-8 text-center">
        <div class="flex justify-center items-center mb-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#8b5cf6] to-[#d946ef] flex items-center justify-center shadow-lg shadow-purple-900/40 mr-3">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                </svg>
            </div>
            <span class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#a78bfa] to-[#e879f9] tracking-tight">PFM</span>
        </div>
        <p class="text-gray-400 text-sm font-medium">Plateforme de gestion universitaire</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Adresse Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="exemple@univ.edu"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Mot de passe</label>
            <input id="password" type="password" name="password" required
                placeholder="••••••••"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-5">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/10 text-[#8b5cf6] focus:ring-[#8b5cf6]">
                <span class="text-xs text-gray-400">Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-[#8b5cf6] hover:text-[#d946ef] transition duration-200">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <div class="mt-7">
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white font-bold rounded-xl shadow-lg shadow-purple-900/30 transition duration-200 transform hover:-translate-y-0.5 text-sm tracking-wide">
                Se connecter →
            </button>
        </div>
    </form>
</x-guest-layout>