@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Affecter un candidat</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('candidates.storeAssignment', $candidate->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="post_id" class="block text-sm font-semibold text-gray-700">Sélectionner un Poste</label>
            <select name="post_id" id="post-selection" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <!-- Les options seront ajoutées dynamiquement par Select2 -->
            </select>
        </div>

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Affecter le candidat</button>
    </form>
</div>
@endsection

@section('scripts')
<!-- Ajout des dépendances de Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.post-dropdown').select2({
            placeholder: 'Saisissez le nom du poste',
            minimumInputLength: 1,
            ajax: {
                url: '/rechercher-postes', // URL de votre API de recherche
                dataType: 'json',
                delay: 250, // Délai pour éviter trop de requêtes
                data: function (params) {
                    return {
                        q: params.term // Le terme de recherche
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.title
                            };
                        })
                    };
                }
            }
        });
    });


</script>
@endsection
