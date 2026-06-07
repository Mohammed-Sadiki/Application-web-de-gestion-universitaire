<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center items-center mb-2">
            <svg class="w-10 h-10 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
            </svg>
            <span class="text-4xl font-extrabold text-blue-600 tracking-tight">PFM</span>
        </div>
        <p class="text-gray-500 text-sm font-medium">Système de gestion académique</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" class="text-gray-700 font-semibold mb-1" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" 
                type="email" name="email" :value="old('email')" required autofocus placeholder="exemple@univ.edu" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-semibold mb-1" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm"
                type="password" name="password" required placeholder="........" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition duration-200 transform hover:-translate-y-0.5">
                {{ __('Se connecter') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a class="text-sm text-gray-500 hover:text-blue-600 transition duration-200" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>