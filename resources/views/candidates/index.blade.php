@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Liste des Candidats</h1>
        <a href="{{ route('candidates.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
            + Ajouter un candidat
        </a>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Recherche -->
    <form method="GET" action="{{ route('candidates.index') }}" class="mb-6">
        <div class="relative">
            <input
                type="text"
                name="search"
                class="w-full p-4 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Rechercher un candidat..."
                value="{{ request('search') }}">
            <svg class="absolute left-3 top-4 w-5 h-5 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M10 2a8 8 0 105.292 14.5l4.31 4.31a1 1 0 001.414-1.414l-4.31-4.31A8 8 0 0010 2zm0 2a6 6 0 110 12A6 6 0 0110 4z"/>
            </svg>
        </div>
    </form>

    <!-- Liste des candidats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($candidates as $candidate)
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $candidate->first_name }} {{ $candidate->last_name }}</h2>
                        <p class="text-sm text-gray-600">{{ $candidate->current_position ?? 'Position non définie' }}</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $candidate->status == 'Disponible' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $candidate->status }}
                    </span>
                </div>
                <!-- Informations détaillées -->
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Email :</strong> {{ $candidate->email }}</p>
                    <p><strong>Téléphone :</strong> {{ $candidate->phone ?? 'Non spécifié' }}</p>
                    <p><strong>Adresse :</strong> {{ $candidate->address ?? 'Non spécifiée' }}</p>
                    <p><strong>Éducation :</strong> {{ $candidate->education ?? 'Non spécifiée' }}</p>
                    <p><strong>École :</strong> {{ $candidate->school ?? 'Non spécifiée' }}</p>
                    <p><strong>Entreprise actuelle :</strong> {{ $candidate->current_company ?? 'Non spécifiée' }}</p>
                    <p><strong>Nationalité :</strong> {{ $candidate->nationality ?? 'Non spécifiée' }}</p>
                    <p><strong>Compétences :</strong> {{ $candidate->skills ?? 'Non spécifiées' }}</p>

                    <!-- Informations de CV -->
                    <p><strong>Domaine :</strong> {{ $candidate->domains ?? 'Non spécifié' }}</p>
                    <p><strong>Diplôme :</strong> {{ $candidate->diploma ?? 'Non spécifié' }}</p>
                    <p><strong>Autres informations :</strong> {{ $candidate->other_information ?? 'Non spécifiées' }}</p>
                </div>
                <!-- Actions -->
                <div class="flex justify-between items-center mt-4">
                    <a href="{{ route('candidates.show', $candidate->id) }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        Voir détails
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('candidates.edit', $candidate->id) }}" class="text-yellow-500 hover:text-yellow-600">
                            Modifier
                        </a>
                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">Supprimer</button>
                        </form>
                        <a href="{{ route('candidates.track', $candidate->id) }}" class="text-gray-500 hover:text-gray-600">
                            Suivre
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                Aucun candidat trouvé.
            </div>
        @endforelse
    </div>
</div>
@endsection
