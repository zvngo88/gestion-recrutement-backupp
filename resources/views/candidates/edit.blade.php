@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Modifier le Candidat: {{ $candidate->name }}</h1>

    <form action="{{ route('candidates.update', $candidate->id) }}" method="POST" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-600">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name', $candidate->name) }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $candidate->email) }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-gray-600">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border rounded-md">
                    <option value="Disponible" {{ old('status', $candidate->status) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Affecté" {{ old('status', $candidate->status) == 'Affecté' ? 'selected' : '' }}>Affecté</option>
                </select>
            </div>

            <div>
                <label for="skills" class="block text-sm font-semibold text-gray-600">Compétences</label>
                <textarea name="skills" id="skills" rows="4" class="mt-1 block w-full px-4 py-2 border rounded-md">{{ old('skills', $candidate->skills) }}</textarea>
            </div>

            <div>
                <label for="resume" class="block text-sm font-semibold text-gray-600">CV (fichier PDF ou DOCX)</label>
                <input type="file" name="resume" id="resume" class="mt-1 block w-full px-4 py-2 border rounded-md" accept=".pdf,.docx">
                @if($candidate->resume)
                    <p class="mt-2 text-sm text-gray-500">CV actuel: <a href="{{ Storage::url($candidate->resume) }}" class="text-blue-500 hover:text-blue-600" target="_blank">Télécharger le CV</a></p>
                @endif
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Mettre à Jour le Candidat</button>
    </form>
</div>
@endsection
