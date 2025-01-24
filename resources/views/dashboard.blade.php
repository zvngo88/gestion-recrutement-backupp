<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Bienvenue sur le tableau de bord</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Explorer les postes -->
                        <a href="{{ route('posts.index') }}" class="block bg-blue-500 text-white text-center py-4 rounded shadow hover:bg-blue-600">
                            Explorer les postes
                        </a>

                        <!-- Gestion des clients -->
                        <a href="{{ route('clients.index') }}" class="block bg-yellow-500 text-white text-center py-4 rounded shadow hover:bg-yellow-600">
                            Accéder à vos clients
                        </a>

                        <!-- Gestion des candidats -->
                        <a href="{{ route('candidates.index') }}" class="block bg-pink-500 text-white text-center py-4 rounded shadow hover:bg-pink-600">
                            Trouver les meilleurs talents
                        </a>

                        <!-- Planification des entretiens -->
                        <a href="{{ route('interviews.index') }}" class="block bg-red-500 text-white text-center py-4 rounded shadow hover:bg-red-600">
                            Gestion des entretiens
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>


</x-app-layout>
