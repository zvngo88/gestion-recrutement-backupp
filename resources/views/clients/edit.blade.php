@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Modifier un Client</h1>

    <!-- Gestion des erreurs -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Informations sur l'entreprise -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations sur l'entreprise</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                <input type="text" name="name" id="name" placeholder="Nom de l'entreprise"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('name', $client->name) }}">
            </div>
            <div>
                <label for="activity" class="block text-sm font-medium text-gray-700">Activité</label>
                <input type="text" name="activity" id="activity" placeholder="Activité"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('activity', $client->activity) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('email', $client->email) }}">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="phone" id="phone" placeholder="Téléphone"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('phone', $client->phone) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="address" id="address" placeholder="Adresse"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('address', $client->address) }}">
            </div>
            

        <!-- Informations sur le contact -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4"></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="contact_name" class="block text-sm font-medium text-gray-700">Nom du contact</label>
                <input type="text" name="contact_name" id="contact_name" placeholder="Nom du contact"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('contact_name', $client->contact_name) }}">
            </div>
            <div>
                <label for="contact_position" class="block text-sm font-medium text-gray-700">Poste du contact</label>
                <input type="text" name="contact_position" id="contact_position" placeholder="Poste du contact"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('contact_position', $client->contact_position) }}">
            </div>
            <div>
                <label for="contact_email" class="block text-sm font-medium text-gray-700">email du contact</label>
                <input type="text" name="contact_email" id="contact_email" placeholder="email du contact"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('contact_email', $client->contact_email) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
           
            <div>
                <label for="contact_phone" class="block text-sm font-medium text-gray-700">Téléphone du contact</label>
                <input type="text" name="contact_phone" id="contact_phone" placeholder="Téléphone du contact"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('contact_phone', $client->contact_phone) }}">
            </div>
        </div>

        <!-- Bouton de mise à jour -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded mt-4">Mettre à jour</button>
    </form>
</div>
@endsection
