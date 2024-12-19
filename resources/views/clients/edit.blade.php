@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Modifier un Client</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                <input type="text" name="name" id="name" placeholder="Nom de l'entreprise"
                       required class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('name', $client->name) }}">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('email', $client->email) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="phone" id="phone" placeholder="Téléphone"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('phone', $client->phone) }}">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="address" id="address" placeholder="Adresse"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('address', $client->address) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <input type="text" name="city" id="city" placeholder="Ville"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('city', $client->city) }}">
            </div>
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                <input type="text" name="country" id="country" placeholder="Pays"
                       class="w-full px-4 py-2 border rounded mt-2"
                       value="{{ old('country', $client->country) }}">
            </div>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded mt-4">Mettre à jour</button>
    </form>
</div>
@endsection
