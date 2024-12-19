@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Liste des Candidats</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de recherche -->
    <form action="{{ route('candidates.index') }}" method="GET" class="mt-4 mb-6">
        <div class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Rechercher par nom ou email" class="px-4 py-2 border rounded-md w-1/3" value="{{ request('search') }}">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('candidates.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Créer un Nouveau Candidat</a>

    <div class="mt-6">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">#</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Nom</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Statut</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">CV</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                    <tr class="border-t border-gray-200 hover:bg-gray-100">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $candidate->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $candidate->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $candidate->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-sm rounded-full {{ $candidate->status === 'Affecté' ? 'bg-green-200 text-green-700' : 'bg-blue-200 text-blue-700' }}">
                                {{ $candidate->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($candidate->resume)
                                <a href="{{ Storage::url($candidate->resume) }}" class="text-blue-500 hover:text-blue-600" target="_blank">Télécharger le CV</a>
                            @else
                                <span class="text-red-500">Pas de CV</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('candidates.edit', $candidate->id) }}" class="text-yellow-500 hover:text-yellow-600">Modifier</a>
                            |
                            <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>

                            @if($candidate->status !== 'Affecté')
                                |
                                <a href="{{ route('candidates.assign', $candidate->id) }}" class="text-blue-500 hover:text-blue-600">Affecter à un poste</a>
                            @else
                                <span class="text-green-500">Affecté</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
