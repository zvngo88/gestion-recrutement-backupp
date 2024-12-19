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

    <!-- Message de succès -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-md border-l-4 border-green-500">
            {{ session('success') }}
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
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Statut</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b border-gray-200">{{ $post->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ Str::limit($post->description, 50) }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b border-gray-200">
                            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $post->status === 'Actif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $post->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center border-b border-gray-200 space-x-3">
                            <!-- Voir le poste -->
                            <a href="{{ route('posts.show', $post->id) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                Voir
                            </a>
                            <!-- Modifier le poste -->
                            <a href="{{ route('posts.edit', $post->id) }}" class="inline-block px-6 py-3 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700 transition duration-300">
                                Modifier
                            </a>
                            <!-- Suivre les étapes -->
                            <a href="{{ route('steps.index', $post->id) }}" class="inline-block px-6 py-3 bg-teal-600 text-white rounded-lg shadow-md hover:bg-teal-700 transition duration-300">
                                Suivre les étapes
                            </a>
                            <!-- Toggle status -->
                            <form action="{{ route('posts.toggleStatus', $post->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-block px-6 py-3 {{ $post->isActif() ? 'bg-red-600' : 'bg-gray-700' }} text-white rounded-lg shadow-md hover:{{ $post->isActif() ? 'bg-red-700' : 'bg-green-700' }} transition duration-300">
                                    {{ $post->isActif() ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                            <!-- Supprimer le poste -->
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block px-6 py-3 bg-red-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition duration-300" onclick="return confirm('Confirmer la suppression ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-600">
                            Aucun poste disponible.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
