<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UPF') }} — University Management Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        /* ── Full screen wrapper ── */
        .login-page {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }

        /* ── Background image ── */
        .login-bg {
            position: absolute;
            inset: 0;
            background-image: url('/images/login-bg.jpg');
            background-size: cover;
            background-position: center right;
            z-index: 0;
        }

        /* ── Dark overlay: strong left → transparent right ── */
        .login-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg,
                    rgba(5, 10, 25, 0.97) 0%,
                    rgba(5, 10, 25, 0.90) 30%,
                    rgba(5, 10, 25, 0.60) 55%,
                    rgba(5, 10, 25, 0.10) 80%,
                    transparent 100%);
            z-index: 1;
        }

        /* ── Lens flare effects (bottom right) ── */
        .flare {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 2;
        }

        .flare-1 {
            width: 600px;
            height: 600px;
            bottom: -200px;
            right: -100px;
            background: radial-gradient(circle, rgba(255, 120, 0, 0.18) 0%, transparent 70%);
        }

        .flare-2 {
            width: 350px;
            height: 350px;
            bottom: -80px;
            right: 200px;
            background: radial-gradient(circle, rgba(120, 80, 255, 0.22) 0%, transparent 70%);
        }

        .flare-3 {
            width: 200px;
            height: 8px;
            bottom: 200px;
            right: 0px;
            background: linear-gradient(90deg, transparent, rgba(255, 140, 50, 0.7), rgba(200, 100, 255, 0.5), transparent);
            transform: rotate(-8deg);
            filter: blur(2px);
        }

        /* ── Left panel: holds form ── */
        .login-panel {
            position: relative;
            z-index: 10;
            width: 420px;
            min-width: 380px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px 52px 36px 52px;
        }

        /* ── Logo area ── */
        .logo-area {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            text-align: center;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }

        .logo-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f97316, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(249, 115, 22, 0.5);
            flex-shrink: 0;
        }

        .logo-icon svg {
            width: 26px;
            height: 26px;
            fill: white;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 900;
            color: #f97316;
            letter-spacing: 2px;
            line-height: 1;
        }

        .logo-subtitle {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            color: rgba(255, 255, 255, 0.45);
            text-transform: uppercase;
            margin-top: 2px;
            margin-left: 2px;
        }

        /* ── Form area ── */
        .form-area {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ── Input fields ── */
        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            z-index: 2;
        }

        .login-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.07);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 14px 18px 14px 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: white;
            outline: none;
            transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
            backdrop-filter: blur(8px);
        }

        .login-input::placeholder {
            color: rgba(255, 255, 255, 0.35);
            font-weight: 400;
        }

        .login-input:focus {
            border-color: rgba(249, 115, 22, 0.7);
            background: rgba(255, 255, 255, 0.10);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        [dir="rtl"] .input-icon {
            left: auto;
            right: 18px;
        }

        [dir="rtl"] .login-input {
            padding: 14px 50px 14px 18px;
        }

        /* ── Sign In button ── */
        .signin-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 6px 30px rgba(249, 115, 22, 0.45);
            margin-top: 4px;
        }

        .signin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(249, 115, 22, 0.60);
            opacity: 0.95;
        }

        .signin-btn:active {
            transform: translateY(0);
        }

        /* ── Links area ── */
        .form-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
        }

        .form-links a {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.78rem;
            font-weight: 400;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-links a:hover {
            color: rgba(255, 255, 255, 0.85);
        }

        /* ── Error messages ── */
        .field-error {
            color: #fb923c;
            font-size: 0.72rem;
            margin-top: 4px;
            padding-left: 4px;
        }

        /* ── Session status ── */
        .session-status {
            background: rgba(249, 115, 22, 0.12);
            border: 1px solid rgba(249, 115, 22, 0.3);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fdba74;
            font-size: 0.8rem;
        }

        /* ── Language switcher (bottom) ── */
        .lang-switcher {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .lang-link {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.35);
            padding: 0 10px;
            transition: color 0.2s;
        }

        .lang-link:first-child {
            padding-left: 0;
        }

        .lang-link.active {
            color: white;
            font-weight: 800;
        }

        .lang-link:hover:not(.active) {
            color: rgba(255, 255, 255, 0.70);
        }

        .lang-sep {
            color: rgba(255, 255, 255, 0.18);
            font-size: 0.65rem;
            user-select: none;
        }

        /* ── Animations ── */
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-panel {
            animation: fadeSlideIn 0.6s ease forwards;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .login-panel {
                width: 100vw;
                min-width: unset;
                padding: 40px 28px 30px 28px;
            }

            .login-overlay {
                background: rgba(5, 10, 25, 0.88);
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <!-- Background -->
        <div class="login-bg"></div>
        <div class="login-overlay"></div>

        <!-- Lens flare effects -->
        <div class="flare flare-1"></div>
        <div class="flare flare-2"></div>
        <div class="flare flare-3"></div>

        <!-- Left Panel -->
        <div class="login-panel">
            <!-- Logo -->
            <div class="logo-area">
                <div class="logo-row">
                    <div class="logo-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 3L1 9L12 15L21 9.5V16.5H23V9L12 3ZM5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z" />
                        </svg>
                    </div>
                    <span class="logo-text">UPF</span>
                </div>
                <p class="logo-subtitle">University Management Platform</p>
            </div>

            <!-- Form Slot -->
            <div class="form-area">
                {{ $slot }}
            </div>

            <!-- Language Switcher -->
            <div class="lang-switcher">
                <a href="{{ route('set-locale', 'ar') }}"
                    class="lang-link {{ app()->getLocale() == 'ar' ? 'active' : '' }}">Arabic</a>
                <span class="lang-sep">|</span>
                <a href="{{ route('set-locale', 'fr') }}"
                    class="lang-link {{ app()->getLocale() == 'fr' ? 'active' : '' }}">French</a>
                <span class="lang-sep">|</span>
                <a href="{{ route('set-locale', 'en') }}"
                    class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">English</a>
            </div>
        </div>
    </div>
</body>

</html>