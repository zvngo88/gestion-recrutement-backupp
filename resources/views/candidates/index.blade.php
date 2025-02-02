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

    <button class="flex justify-between items-center mb-8 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition" onclick="window.print()">Imprimer la page</button>


    <!-- Message de succès -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de recherche -->
    <div class="mb-6">
        <form action="{{ route('candidates.index') }}" method="GET" class="flex items-center">
            <input
                type="text"
                name="search"
                placeholder="Rechercher "
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
            <a href="{{ route('candidates.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">
                Réinitialiser la recherche
            </a>
        </div>
    @endif

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
                            Afficher
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

    <!-- Formulaire de recherche pour les affectations -->
    <div class="mb-6" style="display: block !important;">
        <form action="{{ route('candidates.index') }}" method="GET" class="flex items-center">
            <input
                type="text"
                name="search_post"
                placeholder="Rechercher par poste"
                value="{{ request('search_post') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <input
                type="text"
                name="search_candidate" *
                placeholder="Rechercher par candidat"
                value="{{ request('search_candidate') }}"
                class="w-full px-4 py-2 ml-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300">
                Rechercher
            </button>
        </form>
    </div>

    @if (request('search_post') || request('search_candidate'))
        <div class="mt-4">
            <a href="{{ route('candidates.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">
                Réinitialiser la recherche
            </a>
        </div>
    @endif
    
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
                        <!-- Lien unique vers chaque affectation -->
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


