@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Détails du Candidat: {{ $candidate->name }}</h1>

    <div class="mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <strong class="text-gray-700">Nom :</strong> {{ $candidate->name }}
            </div>
            <div class="mb-4">
                <strong class="text-gray-700">Email :</strong> {{ $candidate->email }}
            </div>
            <div class="mb-4">
                <strong class="text-gray-700">Statut :</strong>
                <span class="px-3 py-1 text-sm rounded-full {{ $candidate->status === 'Affecté' ? 'bg-green-200 text-green-700' : 'bg-blue-200 text-blue-700' }}">
                    {{ $candidate->status }}
                </span>
            </div>
            <div class="mb-4">
                <strong class="text-gray-700">Compétences :</strong> {{ $candidate->skills ?: 'Aucune compétence définie' }}
            </div>

            <div class="mt-6">
                <a href="{{ route('candidates.edit', $candidate->id) }}" class="px-6 py-3 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-all duration-300">Modifier</a>
                <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" class="inline-block ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition-all duration-300" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
