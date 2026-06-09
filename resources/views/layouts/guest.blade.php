<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { background: #070b14; }
            .auth-blob {
                position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.15; pointer-events: none; z-index: 0;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#070b14] text-white">
        <!-- Ambient blobs -->
        <div class="auth-blob w-[500px] h-[500px] bg-[#8b5cf6] top-[-100px] left-[-100px]"></div>
        <div class="auth-blob w-[400px] h-[400px] bg-[#d946ef] bottom-[-80px] right-[-80px]"></div>
        <div class="auth-blob w-[300px] h-[300px] bg-[#06b6d4] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Language Switcher for Guest -->
            <div class="flex gap-4 mb-6 bg-[#0d1220]/50 p-2 rounded-2xl border border-white/10 backdrop-blur-sm">
                <a href="{{ route('set-locale', 'fr') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ app()->getLocale() == 'fr' ? 'bg-[#8b5cf6] text-white' : 'text-gray-400 hover:text-white' }}">FR</a>
                <a href="{{ route('set-locale', 'en') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ app()->getLocale() == 'en' ? 'bg-[#8b5cf6] text-white' : 'text-gray-400 hover:text-white' }}">EN</a>
                <a href="{{ route('set-locale', 'ar') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ app()->getLocale() == 'ar' ? 'bg-[#8b5cf6] text-white' : 'text-gray-400 hover:text-white' }}">AR</a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-[#0d1220]/80 backdrop-blur-xl shadow-2xl shadow-black/60 overflow-hidden sm:rounded-3xl border border-white/10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
