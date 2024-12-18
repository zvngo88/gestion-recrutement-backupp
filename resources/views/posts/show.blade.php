@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Détails du Poste</h1>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Titre : {{ $post->title }}</h4>
            <p class="card-text">Description : {{ $post->description }}</p>
            <p class="card-text">Statut : {{ $post->status }}</p>
        </div>
    </div>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
