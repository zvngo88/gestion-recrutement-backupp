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

    <!-- Tableau des candidats -->
    <table class="table-auto w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Téléphone</th>
                <th class="px-4 py-2">Adresse</th>
                <th class="px-4 py-2">Poste Actuel</th>
                <th class="px-4 py-2">Entreprise Actuelle</th>
                <th class="px-4 py-2">Domaines de Compétence</th>
                <th class="px-4 py-2">École</th>
                <th class="px-4 py-2">Nationalité</th>
                <th class="px-4 py-2">cv</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($candidates as $candidate)
                <tr>
                    <td class="border px-4 py-2">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                    <td class="border px-4 py-2">{{ $candidate->email }}</td>
                    <td class="border px-4 py-2">{{ $candidate->phone }}</td>
                    <td class="border px-4 py-2">{{ $candidate->address }}</td>
                    <td class="border px-4 py-2">{{ $candidate->current_position }}</td>
                    <td class="border px-4 py-2">{{ $candidate->current_company }}</td>
                    <td class="border px-4 py-2">{{ $candidate->skills }}</td>
                    <td class="border px-4 py-2">{{ $candidate->school }}</td>
                    <td class="border px-4 py-2">{{ $candidate->nationality }}</td>
                
                    <td>
                        <form action="{{ route('candidates.uploadCv', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="cv-{{ $candidate->id }}">Télécharger le CV</label>
                            <input type="file" name="cv" id="cv-{{ $candidate->id }}" accept=".pdf,.doc,.docx" required>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Télécharger</button>
                        </form>

                        @if($candidate->cv) <!-- Vérifie si le CV existe -->
                            <br>
                            <a href="{{ asset('storage/' . $candidate->cv) }}" target="_blank" class="text-blue-500">Voir le CV</a> <!-- Lien vers le CV -->
                        @endif
                    </td>


                    <td class="border px-4 py-2">
                        <form method="POST" action="{{ route('assignments.store') }}">
                            @csrf
                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                            <select name="post_id" class="border rounded p-1">
                                <option value="">Sélectionner un poste</option>
                                @foreach($posts as $post)
                                    <option value="{{ $post->id }}">{{ $post->title }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Affecter</button>
                        </form>
                    </td>

                    <td class="border px-4 py-2">
                        
                        <a href="{{ route('candidates.edit', $candidate->id) }}" class="text-yellow-500 hover:text-yellow-600 ml-2">
                            Modifier
                        </a>
                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 ml-2">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center py-4 text-gray-500">Aucun candidat trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    

    <!-- Tableau des affectations -->
    <h2 class="text-2xl font-bold text-gray-800 mt-8">Affectations</h2>
    <table class="table-auto w-full text-left border-collapse mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Poste</th>
                <th class="px-4 py-2">Candidat</th>
                <th class="px-4 py-2">Date d'affectation</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assignments as $assignment)
                <tr>
                    <td class="border px-4 py-2">{{ $assignment->post->title }}</td>
                    <td class="border px-4 py-2">{{ $assignment->candidate->first_name }} {{ $assignment->candidate->last_name }}</td>
                    <td class="border px-4 py-2">{{ $assignment->assigned_at }}</td>
                    <td class="border px-4 py-2">
                      <a href="{{ route('assignments.track', $assignment->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Suivre</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Aucune affectation trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
