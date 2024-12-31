@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Créer un Nouveau Candidat</h1>

    <form action="{{ route('candidates.store') }}" method="POST" class="mt-6" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-600">Prénom</label>
                <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-600">Nom</label>
                <input type="text" name="last_name" id="last_name" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-600">Téléphone</label>
                <input type="text" name="phone" id="phone" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="address" class="block text-sm font-semibold text-gray-600">Adresse</label>
                <input type="text" name="address" id="address" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="current_position" class="block text-sm font-semibold text-gray-600">Poste Actuel</label>
                <input type="text" name="current_position" id="current_position" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="current_company" class="block text-sm font-semibold text-gray-600">Entreprise Actuelle</label>
                <input type="text" name="current_company" id="current_company" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="skills" class="block text-sm font-semibold text-gray-600">Compétences</label>
                <textarea name="skills" id="skills" rows="4" class="mt-1 block w-full px-4 py-2 border rounded-md"></textarea>
            </div>

            <div>
                <label for="cv" class="block text-sm font-semibold text-gray-600">CV (fichier PDF ou DOCX)</label>
                <input type="file" name="cv" id="cv" class="mt-1 block w-full px-4 py-2 border rounded-md" accept=".pdf,.docx">
            </div>

            <div>
                <label for="education" class="block text-sm font-semibold text-gray-600">Éducation</label>
                <input type="text" name="education" id="education" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="school" class="block text-sm font-semibold text-gray-600">École</label>
                <input type="text" name="school" id="school" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="nationality" class="block text-sm font-semibold text-gray-600">Nationalité</label>
                <input type="text" name="nationality" id="nationality" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-gray-600">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border rounded-md">
                    <option value="Disponible">Disponible</option>
                    <option value="Affecté">Affecté</option>
                </select>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Créer le Candidat</button>
    </form>
</div>
@endsection
