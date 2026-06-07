<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PFM - Système de gestion académique</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="min-h-screen flex flex-col items-center justify-center p-6">
            <div class="w-full max-w-2xl bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100 p-12 text-center">
                <div class="flex justify-center items-center mb-6">
                    <svg class="w-16 h-16 text-blue-600 mr-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                    </svg>
                    <span class="text-6xl font-extrabold text-blue-600 tracking-tighter">PFM</span>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenue sur PFM</h1>
                <p class="text-gray-500 text-lg mb-10 max-w-md mx-auto">
                    Le système centralisé de gestion académique pour les étudiants, professeurs et l'administration de l'UPF.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg transition duration-200">
                            Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg transition duration-200">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-white border-2 border-blue-600 text-blue-600 font-bold rounded-2xl hover:bg-blue-50 transition duration-200">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-blue-600 font-bold text-xl">Espace</div>
                        <div class="text-gray-400 text-sm">Étudiant</div>
                    </div>
                    <div class="text-center border-x border-gray-100">
                        <div class="text-blue-600 font-bold text-xl">Espace</div>
                        <div class="text-gray-400 text-sm">Professeur</div>
                    </div>
                    <div class="text-center">
                        <div class="text-blue-600 font-bold text-xl">Espace</div>
                        <div class="text-gray-400 text-sm">Admin</div>
                    </div>
                </div>
            </div>
            
            <footer class="mt-8 text-gray-400 text-sm font-medium">
                © {{ date('Y') }} Université Polytechnique de Fès - Projet de Fin de Module
            </footer>
        </div>
    </body>
</html>