@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Créer un Client</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="mb-6">
        @csrf

        <!-- Informations sur l'entreprise -->
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Informations sur l'entreprise</h2>
        <div class="flex space-x-4 mb-4">
            <input type="text" name="name" placeholder="Nom de l'entreprise" required class="w-1/3 px-4 py-2 border rounded">
            <input type="text" name="activity" placeholder="Activité" required class="w-1/3 px-4 py-2 border rounded">
        </div>
        <div class="flex space-x-4 mb-4">
            <input type="email" name="email" placeholder="Email" required class="w-1/3 px-4 py-2 border rounded">
            <input type="tel" name="phone" placeholder="Téléphone" class="w-1/3 px-4 py-2 border rounded">
        </div>
        <div class="flex space-x-4 mb-4">
            <input type="text" name="address" placeholder="Adresse" class="w-1/3 px-4 py-2 border rounded">
        </div>

        <!-- Informations sur le contact -->
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Informations sur le contact</h2>
        <div class="flex space-x-4 mb-4">
            <input type="text" name="contact_name" placeholder="Nom du contact" required class="w-1/3 px-4 py-2 border rounded">
            <input type="text" name="contact_position" placeholder="Poste du contact" required class="w-1/3 px-4 py-2 border rounded">
        </div>
        <div class="flex space-x-4 mb-4">
            <input type="tel" name="contact_phone" placeholder="Téléphone du contact" class="w-1/3 px-4 py-2 border rounded">
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ajouter Client</button>
    </form>

</div>
@endsection
