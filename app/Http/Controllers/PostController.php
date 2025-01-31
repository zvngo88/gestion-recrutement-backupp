<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Client;


class PostController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le terme de recherche
        $search = $request->input('search');

        // Charger les clients
        $clients = Client::all();

        // Filtrer les postes en fonction du terme de recherche
        $posts = Post::when($search, function ($query, $search) {
            return $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        })->with('client')->get();

        return view('posts.index', compact('posts', 'clients'));
    }

    public function create()
    {
        // Récupérer tous les clients depuis la base de données
        $clients = Client::all(); // Assurez-vous d'importer le modèle Client

        return view('posts.create', compact('clients'));
    }

    public function store(Request $request)
    {
        // Validation des champs du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'duration' => 'nullable|integer|min:1',
            'status' => 'required|in:Actif,Inactif',
            'client_id' => 'required|exists:clients,id', // Validation du client
        ]);

        // Création d'un nouveau poste avec les données envoyées
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => isset($validated['start_date']) ? Carbon::parse($validated['start_date']) : null,
            'duration' => $validated['duration'] ?? null,
            'status' => $validated['status'],
            'client_id' => $validated['client_id'], // Ajout du client_id
        ]);

        // Ajout des étapes par défaut
        $defaultSteps = [
            ['name' => 'Création du poste et finalisation de la CDC', 'start_date' => now(), 'end_date' => now()->addDays(7), 'status' => 'En cours'],
            ['name' => 'Sourcing', 'start_date' => now()->addDays(8), 'end_date' => now()->addDays(14), 'status' => 'En cours'],
            ['name' => 'Analyse des profils', 'start_date' => now()->addDays(15), 'end_date' => now()->addDays(21), 'status' => 'En cours'],
            ['name' => 'Shortliste', 'start_date' => now()->addDays(22), 'end_date' => now()->addDays(28), 'status' => 'En cours'],
            ['name' => 'Entretien entreprise', 'start_date' => now()->addDays(29), 'end_date' => now()->addDays(35), 'status' => 'En cours'],
            ['name' => 'Sélection', 'start_date' => now()->addDays(36), 'end_date' => now()->addDays(42), 'status' => 'En cours'],
            ['name' => 'Confirmation du candidat', 'start_date' => now()->addDays(43), 'end_date' => now()->addDays(49), 'status' => 'En cours'],
            ['name' => 'Clôture de la mission', 'start_date' => now()->addDays(50), 'end_date' => now()->addDays(56), 'status' => 'En cours'],
        ];

        // Associer les étapes au poste
        foreach ($defaultSteps as $step) {
            $post->steps()->create($step);
        }

        // Redirection avec message de succès
        return redirect()->route('posts.index')
                        ->with('success', 'Poste créé avec succès et étapes ajoutées.');
    }



    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $clients = Client::all();

        // Convertir start_date en instance de Carbon si ce n'est pas déjà un objet Carbon
        if ($post->start_date && !($post->start_date instanceof Carbon)) {
            $post->start_date = Carbon::parse($post->start_date);
        }

        return view('posts.edit', compact('post', 'clients'));
    }

    public function update(Request $request, Post $post)
    {
        // Validation des champs du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'duration' => 'nullable|integer|min:1',
            'client_id' => 'nullable|exists:clients,id', // Validation du client
            'status' => 'required|in:Actif,Inactif',
        ]);

        // Mise à jour du poste avec les nouvelles données
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date ? Carbon::parse($request->start_date) : null,
            'duration' => $request->duration,
            'client_id' => $request->client_id, // Mise à jour du client_id
            'status' => $request->status,
        ]);

        return redirect()->route('posts.index')
                         ->with('success', 'Poste mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Poste supprimé avec succès.');
    }

    public function toggleStatus(Post $post)
    {
        // Basculer le statut entre "Actif" et "Inactif"
        $post->status = $post->status === 'Actif' ? 'Inactif' : 'Actif';
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Le statut du poste a été mis à jour.');
    }

    public function getPostsByClient($clientId)
    {
        $posts = Post::where('client_id', $clientId)->get(['id', 'title']); // Renvoie les ID et titres des postes
        return response()->json($posts);
    }
}
