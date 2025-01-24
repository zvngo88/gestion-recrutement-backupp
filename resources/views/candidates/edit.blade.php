@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Modifier le Candidat: {{ $candidate->first_name }} {{ $candidate->last_name }}</h1>
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('candidates.update', $candidate->id) }}" method="POST" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <!-- Prénom -->
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-600">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $candidate->first_name) }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <!-- Nom -->
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-600">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $candidate->last_name) }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $candidate->email) }}" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>

            <!-- Téléphone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-600">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $candidate->phone) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- Adresse -->
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-600">Adresse</label>
                <input type="text" name="address" id="address" value="{{ old('address', $candidate->address) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- Poste actuel -->
            <div>
                <label for="current_position" class="block text-sm font-semibold text-gray-600">Poste actuel</label>
                <input type="text" name="current_position" id="current_position" value="{{ old('current_position', $candidate->current_position) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- Entreprise actuelle -->
            <div>
                <label for="current_company" class="block text-sm font-semibold text-gray-600">Entreprise actuelle</label>
                <input type="text" name="current_company" id="current_company" value="{{ old('current_company', $candidate->current_company) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- Compétences -->
            <div>
                <label for="skills" class="block text-sm font-semibold text-gray-600">Compétences</label>
                <textarea name="skills" id="skills" rows="4" class="mt-1 block w-full px-4 py-2 border rounded-md">{{ old('skills', $candidate->skills) }}</textarea>
            </div>

            <!-- Éducation -->
            <div>
                <label for="education" class="block text-sm font-semibold text-gray-600">Éducation</label>
                <input type="text" name="education" id="education" value="{{ old('education', $candidate->education) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- École -->
            <div>
                <label for="school" class="block text-sm font-semibold text-gray-600">École</label>
                <input type="text" name="school" id="school" value="{{ old('school', $candidate->school) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            <!-- Nationalité -->
            <div>
                <label for="nationality" class="block text-sm font-semibold text-gray-600">Nationalité</label>
                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $candidate->nationality) }}" class="mt-1 block w-full px-4 py-2 border rounded-md">
            </div>

            
            
            <!-- Statut -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-600">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border rounded-md">
                    <option value="Disponible" {{ old('status', $candidate->status) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Affecté" {{ old('status', $candidate->status) == 'Affecté' ? 'selected' : '' }}>Affecté</option>
                </select>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Mettre à Jour le Candidat</button>
    </form>
</div>
@endsection
