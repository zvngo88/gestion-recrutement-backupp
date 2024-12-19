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
            <select name="post_id" id="post_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->title }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-300">Affecter le candidat</button>
    </form>
</div>
@endsection
