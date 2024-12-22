@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Modifier le Poste</h1>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Titre</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('title', $post->title) }}" required>
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="5">{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="start_date" class="block text-lg font-medium text-gray-700 mb-2">Date de début</label>
                <input type="date" name="start_date" id="start_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('start_date', $post->start_date ? $post->start_date->format('Y-m-d') : '') }}">
                @error('start_date')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="duration" class="block text-lg font-medium text-gray-700 mb-2">Durée (en jours)</label>
                <input type="number" name="duration" id="duration" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('duration', $post->duration) }}">
                @error('duration')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="block text-lg font-medium text-gray-700 mb-2">Statut</label>
                <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Actif" {{ old('status', $post->status) == 'Actif' ? 'selected' : '' }}>Actif</option>
                    <option value="Inactif" {{ old('status', $post->status) == 'Inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
                @error('status')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Mettre à jour
                </button>
                <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
