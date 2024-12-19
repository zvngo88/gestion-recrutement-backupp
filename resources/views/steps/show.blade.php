@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-semibold text-gray-800">Suivi des étapes pour {{ $candidate->name }} (Poste: {{ $post->title }})</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('steps.updateStatus', [$candidate->id, $post->id, $step->id]) }}" method="POST">
        @csrf
        @method('PATCH')

        @foreach ($steps as $step)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">{{ $step->name }}</label>
                <div class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ $step->status ? 'checked' : '' }}>
                    <label for="status" class="ml-2">OK</label>
                </div>
                <textarea name="justification" class="mt-2 w-full p-2 border border-gray-300 rounded-md" placeholder="Justification (facultatif)">{{ $step->justification }}</textarea>
            </div>
        @endforeach

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Mettre à jour</button>
    </form>
</div>
@endsection
