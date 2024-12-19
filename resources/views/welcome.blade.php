<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        @auth
        <div class="w-full max-w-4xl mx-auto p-6 bg-white shadow rounded">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Bienvenue sur le tableau de bord</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Explorer les postes -->
                <a href="{{ route('posts.index') }}" class="block bg-blue-500 text-white text-center py-4 rounded shadow hover:bg-blue-600">
                    Explorer les postes
                </a>

                <!-- Gestion des clients -->
                <a href="{{ route('clients.index') }}" class="block bg-yellow-500 text-white text-center py-4 rounded shadow hover:bg-yellow-600">
                    Gestion des clients
                </a>

                <!-- Gestion des candidats -->
                <a href="{{ route('candidates.index') }}" class="block bg-pink-500 text-white text-center py-4 rounded shadow hover:bg-pink-600">
                    Gestion des candidats
                </a>

                <!-- Planification des entretiens -->
                <a href="{{ route('interviews.index') }}" class="block bg-red-500 text-white text-center py-4 rounded shadow hover:bg-red-600">
                    Planifier un entretien
                </a>
            </div>
        </div>
        @else
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenue !</h1>
            <p class="mt-4 text-gray-600">Connectez-vous ou inscrivez-vous pour accéder aux fonctionnalités.</p>
            <div class="mt-6 flex justify-center gap-4">
                <!-- Bouton Connexion -->
                <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600">
                    Connexion
                </a>
                <!-- Bouton Inscription -->
                <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600">
                    Inscription
                </a>
            </div>
        </div>
        @endauth
    </div>
</body>
</html>
