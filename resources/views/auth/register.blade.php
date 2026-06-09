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
        <p class="text-gray-400 text-sm font-medium">Créer votre compte académique</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                placeholder="John Doe"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Adresse Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                placeholder="exemple@univ.edu"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Mot de passe</label>
            <input id="password" type="password" name="password" required
                placeholder="••••••••"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                placeholder="••••••••"
                class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6] transition placeholder-gray-600">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[#d946ef] text-xs" />
        </div>

        <div class="mt-7">
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white font-bold rounded-xl shadow-lg shadow-purple-900/30 transition duration-200 transform hover:-translate-y-0.5 text-sm tracking-wide">
                S'inscrire →
            </button>
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-[#8b5cf6] transition duration-200">
                Déjà inscrit ? Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>