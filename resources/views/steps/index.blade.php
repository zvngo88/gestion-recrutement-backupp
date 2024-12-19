@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Suivi des étapes pour : {{ $post->title }}</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('steps.store', $post->id) }}" method="POST" class="mb-6">
        @csrf
        <div class="flex space-x-4 mb-4">
            <input type="text" name="name" placeholder="Nom de l'étape" required class="w-1/3 px-4 py-2 border rounded">
            <input type="date" name="start_date" placeholder="Date début" class="w-1/3 px-4 py-2 border rounded">
            <input type="date" name="end_date" placeholder="Date fin" class="w-1/3 px-4 py-2 border rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ajouter Étape</button>
    </form>

    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Nom</th>
                <th class="px-4 py-2 border">Statut</th>
                <th class="px-4 py-2 border">Date Début</th>
                <th class="px-4 py-2 border">Date Fin</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($steps as $step)
                <tr>
                    <td class="px-4 py-2 border">{{ $step->name }}</td>
                    <td class="px-4 py-2 border">
                        <form method="POST" action="{{ route('steps.update', ['post' => $post->id, 'candidate' => $candidate->id, 'step' => $step->id]) }}">
                            @csrf
                            @method('PATCH')

                            <label for="status">Status</label>
                            <input type="checkbox" id="status" name="status" value="1" {{ $step->status ? 'checked' : '' }}>

                            <button type="submit">Mettre à jour</button>
                        </form>
                    </td>

                    <td class="px-4 py-2 border">{{ $step->start_date }}</td>
                    <td class="px-4 py-2 border">{{ $step->end_date }}</td>
                    <td class="px-4 py-2 border">
                        <form action="{{ route('steps.update', ['post' => $post->id, 'candidate' => $candidate->id, 'step' => $step->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="date" name="start_date" value="{{ $step->start_date }}" class="px-2 py-1 border rounded">
                            <input type="date" name="end_date" value="{{ $step->end_date }}" class="px-2 py-1 border rounded">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Enregistrer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center">Aucune étape disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
