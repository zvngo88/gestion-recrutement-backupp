@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Liste des Clients</h1>

    <div class="mb-4">
        <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded mb-4">Ajouter un client</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Nom de l'entreprise</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Téléphone</th>
                <th class="px-4 py-2 border">Adresse</th>
                <th class="px-4 py-2 border">Ville</th>
                <th class="px-4 py-2 border">Pays</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td class="px-4 py-2 border">{{ $client->name }}</td>
                    <td class="px-4 py-2 border">{{ $client->email }}</td>
                    <td class="px-4 py-2 border">{{ $client->phone }}</td>
                    <td class="px-4 py-2 border">{{ $client->address }}</td>
                    <td class="px-4 py-2 border">{{ $client->city }}</td>
                    <td class="px-4 py-2 border">{{ $client->country }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('clients.edit', $client->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier</a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center">Aucun client disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
