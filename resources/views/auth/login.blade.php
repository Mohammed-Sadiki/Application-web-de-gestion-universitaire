<x-guest-layout>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:14px;">
        @csrf

        {{-- Login / Email --}}
        <div>
            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke-linecap="round"/>
                </svg>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="{{ __('app.email_placeholder') ?? 'Login' }}"
                    class="login-input"
                >
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="5" y="11" width="14" height="10" rx="2"/>
                    <path d="M8 11V7a4 4 0 0 1 8 0v4" stroke-linecap="round"/>
                    <circle cx="12" cy="16" r="1.2" fill="currentColor" stroke="none"/>
                </svg>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('app.password_placeholder') ?? 'Password' }}"
                    class="login-input"
                >
            </div>
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Sign In Button --}}
        <button type="submit" class="signin-btn">
            {{ strtoupper(__('app.login_button') ?? 'Sign In') }}
        </button>

        {{-- Links --}}
        <div class="form-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('app.forgot_password') ?? 'Forgot your password?' }}
                </a>
            @endif
            <a href="#">
                {{ __('First account activation') }}
            </a>
        </div>
    </form>

</x-guest-layout>
