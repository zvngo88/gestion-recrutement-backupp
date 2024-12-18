@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Détails du Poste</h1>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Titre :</h4>
        <p class="text-lg text-gray-700 mb-6">{{ $post->title }}</p>

        <h4 class="text-xl font-semibold text-gray-800 mb-4">Description :</h4>
        <p class="text-lg text-gray-700 mb-6">{{ $post->description }}</p>

        <h4 class="text-xl font-semibold text-gray-800 mb-4">Statut :</h4>
        <p class="text-lg text-gray-700 mb-6">
            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $post->status === 'Actif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $post->status }}
            </span>
        </p>

        <div class="flex justify-start">
            <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
