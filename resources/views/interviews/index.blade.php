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
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <label for="client_id" class="block text-sm font-semibold text-gray-600">Client</label>
                <select name="client_id" id="client_id" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="candidate_id" class="block text-sm font-semibold text-gray-600">Candidat</label>
                <select name="candidate_id" id="candidate_id" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                    <option value="">Sélectionner un candidat</option>
                    @foreach ($candidates as $candidate)
                        <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="interview_date" class="block text-sm font-semibold text-gray-600">Date</label>
                <input type="datetime-local" name="interview_date" id="interview_date" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Planifier</button>
    </form>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-gray-700">Entretiens Planifiés</h2>
        <table class="mt-4 min-w-full table-auto border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Client</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Candidat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interviews as $interview)
                    <tr class="border-t border-gray-200 hover:bg-gray-100">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $interview->client->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $interview->candidate->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $interview->interview_date->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('interviews.email', $interview->id) }}" class="text-blue-500 hover:text-blue-600">Planifier dans Outlook</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
