@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Suivi de l'affectation</h1>

    <!-- Informations -->
    <p class="mb-2"><strong>Candidat :</strong> {{ $assignment->candidate->name }}</p>
    <p class="mb-2"><strong>Poste :</strong> {{ $assignment->post->title }}</p>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="mb-4 font-bold">Étapes :</h3>
    <form action="{{ route('candidates.updateSteps', ['candidate' => $candidate->id]) }}" method="POST" id="updateStepsForm">
        @csrf
        @method('PUT')
        @foreach ($steps as $index => $step)
            <div class="mb-6 step" id="step-{{ $index }}">
                <p class="font-semibold">{{ $step->name }}</p>

                <label>
                    <input 
                        type="radio" 
                        name="status[{{ $index }}]" 
                        value="notok" 
                        class="status-radio" 
                        data-index="{{ $index }}" 
                        {{ $step->status == 'notok' ? 'checked' : '' }}
                    > ok
                </label>

                <label>
                    <input 
                        type="radio" 
                        name="status[{{ $index }}]" 
                        value="ok" 
                        class="status-radio" 
                        data-index="{{ $index }}" 
                        {{ $step->status == 'ok' ? 'checked' : '' }}
                    > not ok
                </label>
                

                <textarea 
                    name="reason[{{ $index }}]" 
                    id="reason-{{ $index }}" 
                    class="reason-input mt-2 w-full p-2 border rounded" 
                    placeholder="Raison (optionnel)" 
                    rows="2"
                    style="display: {{ $step->status == 'notok' ? 'block' : 'none' }};"
                    {{ $step->status == 'notok' ? '' : 'disabled' }}
                >{{ $step->reason }}</textarea>
            </div>
        @endforeach

        <div class="mt-6">
             <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="document.getElementById('updateStepsForm').submit();">Mettre à jour les étapes</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('.status-radio');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            const currentIndex = parseInt(this.dataset.index);
            const isOk = this.value === 'ok';
            const isNotOk = this.value === 'notok';

            // Champ "Raison" pour l'étape actuelle
            const reasonField = document.querySelector(`#reason-${currentIndex}`);
            if (reasonField) {
                // Si "OK" est sélectionné, afficher le champ de raison
                // Si "NOT OK" est sélectionné, masquer le champ de raison
                reasonField.style.display = isOk ? 'block' : 'none';
                reasonField.disabled = !isOk;
            }

            // Désactiver les étapes suivantes si "OK" est sélectionné
            radios.forEach(otherRadio => {
                const otherIndex = parseInt(otherRadio.dataset.index);
                if (otherIndex > currentIndex) {
                    otherRadio.disabled = isOk;
                } else {
                    otherRadio.disabled = false;
                }
            });

            // Désactiver ou masquer les champs de raison des étapes suivantes
            document.querySelectorAll('.reason-input').forEach((textarea, idx) => {
                if (idx > currentIndex) {
                    textarea.disabled = isOk; // Désactiver si "OK" est sélectionné
                    textarea.style.display = isOk ? 'none' : 'block'; // Toujours masquer les champs suivants si "OK"
                }
            });
        });
    });
});



</script>
@endsection