@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Liste des Clients</h1>

    <!-- Bouton pour ajouter un client -->
    <div class="mb-4">
        <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-4">Ajouter un client</a>
    </div>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des clients -->
    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <!-- Colonnes entreprise -->
                <th class="px-4 py-2 border">Nom de l'entreprise</th>
                <th class="px-4 py-2 border">Activité</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Téléphone</th>
                <th class="px-4 py-2 border">Adresse</th>
                <!-- Colonnes contact -->
                <th class="px-4 py-2 border">Nom du Contact</th>
                <th class="px-4 py-2 border">Poste</th>
                <th class="px-4 py-2 border">Téléphone du Contact</th>
                <!-- Actions -->
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <!-- Données de l'entreprise -->
                    <td class="px-4 py-2 border">{{ $client->name }}</td>
                    <td class="px-4 py-2 border">{{ $client->activity }}</td>
                    <td class="px-4 py-2 border">{{ $client->email }}</td>
                    <td class="px-4 py-2 border">{{ $client->phone }}</td>
                    <td class="px-4 py-2 border">{{ $client->address }}</td>
                
                    <!-- Données du contact -->
                    <td class="px-4 py-2 border">{{ $client->contact_name }}</td>
                    <td class="px-4 py-2 border">{{ $client->contact_position }}</td>
                    <td class="px-4 py-2 border">{{ $client->contact_phone }}</td>
                    <!-- Actions -->
                    <td class="px-4 py-2 border">
                        <a href="{{ route('clients.edit', $client->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier</a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <!-- Message si aucun client n'est disponible -->
                <tr>
                    <td colspan="12" class="px-4 py-2 text-center">Aucun client disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
