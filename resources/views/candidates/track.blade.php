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
    <div id="etapes" data-candidat-id="{{ $assignment->candidate->id }}" data-poste-id="{{ $assignment->post->id }}" >
        <!-- Étape 1: Préselection -->
        <div class="etape">
            <p>Étape 1: Préselection</p>
            <label>
                <input type="radio" name="etape1" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape1" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <!-- Étape 2: Premier contact -->
        <div class="etape">
            <p>Étape 2: Premier contact</p>
            <label>
                <input type="radio" name="etape2" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape2" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <!-- Étape 3.1: 1er entretien -->
        <div class="etape">
            <p>Étape 3.1: 1er entretien</p>
            <label>
                <input type="radio" name="etape3_1" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape3_1" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <div class="etape">
            <p>Étape 3.2: 2e entretien</p>
            <label>
                <input type="radio" name="etape3_2" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape3_2" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <div class="etape">
            <p>Étape 4: Évaluation</p>
            <label>
                <input type="radio" name="etape4" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape4" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <div class="etape">
            <p>Étape 5: Qualification de la candidature</p>
            <label>
                <input type="radio" name="etape5" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape5" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <div class="etape">
            <p>Étape 6: Présentation de l'entreprise</p>
            <label>
                <input type="radio" name="etape6" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape6" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

        <div class="etape">
            <p>Étape 7: Confirmation de la candidature</p>
            <label>
                <input type="radio" name="etape7" value="ok"> OK
            </label>
            <label>
                <input type="radio" name="etape7" value="notok"> Not OK
            </label>
            <div class="raison" style="display: none;">
                <textarea placeholder="Entrez la raison..."></textarea>
            </div>
        </div>

    </div>

    <button id="suivre" class="flex justify-between items-center mb-8 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">Enregistrer et Suivre</button>

    <button class="flex justify-between items-center mb-8 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition" onclick="window.print()">Imprimer la page</button>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const etapesContainer = document.getElementById('etapes');
        const candidatId = etapesContainer.getAttribute('data-candidat-id'); // Récupérer l'ID du candidat
        const posteId = etapesContainer.getAttribute('data-poste-id'); // Récupérer l'ID du poste
        const etapes = etapesContainer.querySelectorAll('.etape');

        // Charger les données sauvegardées pour ce candidat et poste
        const savedData = JSON.parse(localStorage.getItem('suiviCandidats')) || {};
        const posteData = savedData[posteId] || {};
        const candidatData = posteData[candidatId] || [];

        if (candidatData.length > 0) {
            candidatData.forEach(item => {
                const etape = etapes[item.etape - 1];
                const radio = etape.querySelector(`input[value="${item.status}"]`);
                if (radio) {
                    radio.checked = true;
                    if (item.status === 'notok') {
                        etape.querySelector('.raison').style.display = 'block';
                        etape.querySelector('textarea').value = item.raison;
                        // Désactiver les étapes suivantes
                        for (let i = item.etape; i < etapes.length; i++) {
                            etapes[i].querySelectorAll('input[type="radio"]').forEach(input => {
                                input.disabled = true;
                            });
                        }
                    }
                }
            });
        }

        // Gérer les changements de statut (OK / Not OK)
        etapes.forEach((etape, index) => {
            const radios = etape.querySelectorAll('input[type="radio"]');
            const raison = etape.querySelector('.raison');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'notok') {
                        raison.style.display = 'block';
                        // Désactiver les étapes suivantes
                        for (let i = index + 1; i < etapes.length; i++) {
                            etapes[i].querySelectorAll('input[type="radio"]').forEach(input => {
                                input.disabled = true;
                            });
                        }
                    } else {
                        raison.style.display = 'none';
                        // Réactiver les étapes suivantes
                        for (let i = index + 1; i < etapes.length; i++) {
                            etapes[i].querySelectorAll('input[type="radio"]').forEach(input => {
                                input.disabled = false;
                            });
                        }
                    }
                });
            });
        });

        // Enregistrer les données lorsque l'utilisateur clique sur "Enregistrer et Suivre"
        document.getElementById('suivre').addEventListener('click', function() {
            const data = [];
            etapes.forEach((etape, index) => {
                const selected = etape.querySelector('input[type="radio"]:checked');
                if (selected) {
                    data.push({
                        etape: index + 1,
                        status: selected.value,
                        raison: selected.value === 'notok' ? etape.querySelector('textarea').value : null
                    });
                }
            });

            // Sauvegarder les données spécifiquement pour ce poste et candidat
            const suiviCandidats = JSON.parse(localStorage.getItem('suiviCandidats')) || {};
            if (!suiviCandidats[posteId]) {
                suiviCandidats[posteId] = {};
            }
            suiviCandidats[posteId][candidatId] = data;  // Utiliser l'ID du candidat et du poste pour l'enregistrement spécifique
            localStorage.setItem('suiviCandidats', JSON.stringify(suiviCandidats));

            console.log('Données enregistrées pour', candidatId, posteId, ':', data);
            alert('Données enregistrées avec succès !');
        });
    });

</script>
@endsection
