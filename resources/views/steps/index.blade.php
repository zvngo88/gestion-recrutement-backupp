@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Suivi des étapes pour : {{ $post->title }}</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    

    <!-- Table des étapes -->
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
                <tr class="{{ $step->status === 'notok' ? 'disabled-row' : '' }}">
                    <td class="px-4 py-2 border">{{ $step->name }}</td>
                    <td class="px-4 py-2 border">
                        <form method="POST" action="{{ route('steps.update', ['post' => $post->id, 'step' => $step->id]) }}">
                        @csrf
                        @method('PATCH')

                        <label for="status">Statut</label>

                        <!-- Boutons radio pour sélectionner le statut -->
                        <div class="flex space-x-4">
                            <label>
                                <input type="radio" name="status" value="ok" {{ $step->status === 'ok' ? 'checked' : '' }}>
                                OK
                            </label>
                            <label>
                                <input type="radio" name="status" value="notok" {{ $step->status === 'notok' ? 'checked' : '' }}>
                                Not OK
                            </label>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded ml-2">Mettre à jour</button>
                    </form>

                    </td>
                    <td class="px-4 py-2 border">{{ $step->start_date }}</td>
                    <td class="px-4 py-2 border">{{ $step->end_date }}</td>
                    <td class="px-4 py-2 border">
                        <!-- Formulaire pour mettre à jour les dates -->
                        <form action="{{ route('steps.update', ['post' => $post->id, 'step' => $step->id]) }}" method="POST">
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

@section('script')
<script>
    function updateStepStatus(index, status) {
        const rows = document.querySelectorAll("tbody tr"); // Sélectionner toutes les lignes du tableau
        let disable = false; // Gérer l'état de désactivation

        rows.forEach((row, i) => {
            const inputs = row.querySelectorAll("input, button");

            if (i > index) {
                inputs.forEach(input => {
                    if (status === "notok" || disable) {
                        input.disabled = true; // Désactiver les champs
                        if (input.type === "radio") {
                            input.checked = false; // Décochez les radios
                        }
                    } else {
                        input.disabled = false; // Réactiver si nécessaire
                    }
                });

                // Ajouter ou retirer la classe pour visuellement désactiver la ligne
                if (status === "notok" || disable) {
                    row.classList.add("disabled-row");
                } else {
                    row.classList.remove("disabled-row");
                }
            }

            // Désactiver toutes les étapes suivantes si l'étape actuelle est "Not OK"
            if (i === index && status === "notok") {
                disable = true;
            }
        });
    }
</script>
@endsection

@section('style')
<style>
    .disabled-row {
        opacity: 0.5; /* Réduction de la visibilité */
        pointer-events: none; /* Désactiver les interactions */
    }
</style>
@endsection

