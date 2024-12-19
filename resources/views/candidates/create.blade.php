@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Créer un Nouveau Candidat</h1>

    <form action="{{ route('candidates.store') }}" method="POST" class="mt-6" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-600">Nom</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-gray-600">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border rounded-md">
                    <option value="Disponible">Disponible</option>
                    <option value="Affecté">Affecté</option>
                </select>
            </div>

            <div>
                <label for="skills" class="block text-sm font-semibold text-gray-600">Compétences</label>
                <textarea name="skills" id="skills" rows="4" class="mt-1 block w-full px-4 py-2 border rounded-md"></textarea>
            </div>

            <div>
                <label for="resume" class="block text-sm font-semibold text-gray-600">CV (fichier PDF ou DOCX)</label>
                <input type="file" name="resume" id="resume" class="mt-1 block w-full px-4 py-2 border rounded-md" accept=".pdf,.docx">
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Créer le Candidat</button>
    </form>
</div>
@endsection
