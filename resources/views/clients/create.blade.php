@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Créer un Client</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex space-x-4 mb-4">
            <input type="text" name="name" placeholder="Nom de l'entreprise" required class="w-1/3 px-4 py-2 border rounded">
            <input type="email" name="email" placeholder="Email" required class="w-1/3 px-4 py-2 border rounded">
            <input type="tel" name="phone" placeholder="Téléphone" class="w-1/3 px-4 py-2 border rounded">
        </div>
        <div class="flex space-x-4 mb-4">
            <input type="text" name="address" placeholder="Adresse" class="w-1/3 px-4 py-2 border rounded">
            <input type="text" name="city" placeholder="Ville" class="w-1/3 px-4 py-2 border rounded">
            <input type="text" name="country" placeholder="Pays" class="w-1/3 px-4 py-2 border rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ajouter Client</button>
    </form>
</div>
@endsection
