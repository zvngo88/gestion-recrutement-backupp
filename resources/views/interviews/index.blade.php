@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Planifier un Entretien</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('interviews.store') }}" method="POST" class="mt-6">
        @csrf
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <!-- Menu déroulant Client -->
            <div>
                <label for="client_id" class="block text-sm font-semibold text-gray-600">Client</label>
                <select name="client_id" id="client_id" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Menu déroulant Postes -->
            <div>
                <label for="post_id" class="block text-sm font-semibold text-gray-600">Poste</label>
                <select name="post_id" id="post_id" class="mt-1 block w-full px-4 py-2 border rounded-md">
                    <option value="">Sélectionner un poste</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>

            

            <!-- Menu déroulant Candidat -->
            <div>
                <label for="candidate_id" class="block text-sm font-semibold text-gray-600">Candidat</label>
                <select name="candidate_id" id="candidate_id" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                    <option value="">Sélectionner un candidat</option>
                    @foreach ($candidates as $candidate)
                        <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sélection de la date -->
            <div>
                <label for="interview_date" class="block text-sm font-semibold text-gray-600">Date</label>
                <input type="datetime-local" name="interview_date" id="interview_date" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>
        </div>


        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Planifier</button>
    </form>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-gray-700">Entretiens Planifiés</h2>
            <table class="mt-6 w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Client</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Poste</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Candidat</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interviews as $interview)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $interview->client->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $interview->post->title }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $interview->candidate->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $interview->interview_date }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('interviews.email', $interview->id) }}" class="text-blue-500 hover:text-blue-600">Planifier dans Outlook</a>
                        </td>
                    </tr>
                @endforeach
                @yield('scripts')

            </tbody>
        </table>
    </div>

    <button class="flex justify-between items-center mb-8 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition" onclick="window.print()">Imprimer la page</button>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clientSelect = document.getElementById('client_id'); // Sélecteur Client
        const postSelect = document.getElementById('post_id');    // Sélecteur Poste
        const candidateSelect = document.getElementById('candidate_id'); // Sélecteur Candidat

        // Mettre à jour les postes en fonction du client sélectionné
        clientSelect.addEventListener('change', function () {
            const clientId = this.value; // Récupère l'ID du client sélectionné
            console.log("Client sélectionné :", clientId);

            postSelect.innerHTML = '<option value="">Chargement...</option>';

            if (clientId) {
                fetch(`/posts-by-client/${clientId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur de réseau');
                        }
                        return response.json();
                    })
                    .then(posts => {
                        console.log("Postes reçus :", posts);
                        postSelect.innerHTML = '<option value="">Sélectionner un poste</option>';
                        posts.forEach(post => {
                            const option = document.createElement('option');
                            option.value = post.id;
                            option.textContent = post.title;
                            postSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error("Erreur de chargement des postes :", error);
                        postSelect.innerHTML = '<option value="">Erreur de chargement des postes</option>';
                    });
            }
        });

        // Mettre à jour les candidats en fonction du poste sélectionné
        postSelect.addEventListener('change', function () {
            const postId = this.value; // Récupère l'ID du poste sélectionné
            console.log("Poste sélectionné :", postId);

            candidateSelect.innerHTML = '<option value="">Chargement...</option>';

            if (postId) {
                fetch(`/candidates-by-post/${postId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur de réseau');
                        }
                        return response.json();
                    })
                    .then(candidates => {
                        console.log("Candidats reçus :", candidates);
                        candidateSelect.innerHTML = '<option value="">Sélectionner un candidat</option>';
                        candidates.forEach(candidate => {
                            const option = document.createElement('option');
                            option.value = candidate.id;
                            option.textContent = candidate.name;
                            candidateSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error("Erreur de chargement des candidats :", error);
                        candidateSelect.innerHTML = '<option value="">Erreur de chargement des candidats</option>';
                    });
            }
        });
    });


    

</script>

@endsection
