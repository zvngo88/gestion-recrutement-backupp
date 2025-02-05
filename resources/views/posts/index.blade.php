@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-semibold text-gray-900">Liste des Postes</h1>
        <a href="{{ route('posts.create') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300">
            Créer un Nouveau Poste
        </a>
    </div>

    <!-- Formulaire de recherche -->
    <div class="mb-6">
        <form action="{{ route('posts.index') }}" method="GET" class="flex items-center">
            <input
                type="text"
                name="search"
                placeholder="Rechercher par client..."
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Réinitialiser la recherche -->
    @if (request('search'))
        <div class="mt-4">
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">
                Réinitialiser la recherche
            </a>
        </div>
    @endif

    <!-- Messages -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-md border-l-4 border-green-500">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow-md border-l-4 border-red-500">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tableau des postes -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Titre</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date de début</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Durée (en jours)</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date de création</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Client</th> 
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Statut</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b border-gray-200">{{ $post->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">
                            {{ Str::limit($post->description, 50, '...') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">
                            {{ $post->start_date ? \Carbon\Carbon::parse($post->start_date)->format('d/m/Y') : 'Non défini' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">
                            {{ $post->duration ? $post->duration . ' jours' : 'Non défini' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">
                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">
                            {{ $post->client ? $post->client->name : 'Aucun client' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b border-gray-200">
                            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $post->status === 'Actif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $post->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center border-b border-gray-200">
                            <div class="flex justify-center space-x-2">
                                <!-- Voir le poste -->
                                <a href="{{ route('posts.show', $post->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                    Voir
                                </a>
                                <!-- Modifier le poste -->
                                <a href="{{ route('posts.edit', $post->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700 transition duration-300">
                                    Modifier
                                </a>
                                <!-- Suivre les étapes -->
                                <a href="{{ route('steps.index', $post->id) }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg shadow-md hover:bg-teal-700 transition duration-300">
                                    Suivre
                                </a>
                                <!-- Toggle status -->
                                <form action="{{ route('posts.toggleStatus', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 {{ $post->isActif() ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-lg shadow-md hover:{{ $post->isActif() ? 'bg-red-700' : 'bg-green-700' }} transition duration-300">
                                        {{ $post->isActif() ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                <!-- Supprimer le poste -->
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition duration-300" onclick="return confirm('Confirmer la suppression ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-600">
                            Aucun poste disponible.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <button class="flex justify-between items-center mb-8 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition" onclick="window.print()">Imprimer la page</button>
</div>
@endsection