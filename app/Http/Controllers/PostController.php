<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validation des champs du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'duration' => 'nullable|integer|min:1', // La durée doit être un entier positif
            'status' => 'required|in:Actif,Inactif', // Validation du statut
        ]);

        // Création d'un nouveau poste avec les données envoyées
        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => isset($validated['start_date']) ? Carbon::parse($validated['start_date']) : null,
            'duration' => $validated['duration'] ?? null,
            'status' => $validated['status'],
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

        // Convertir start_date en instance de Carbon si ce n'est pas déjà un objet Carbon
        if ($post->start_date && !($post->start_date instanceof Carbon)) {
            $post->start_date = Carbon::parse($post->start_date);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Validation des champs du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today',
            'duration' => 'nullable|integer|min:1',
            'status' => 'required|in:Actif,Inactif',
        ]);

        // Mise à jour du poste avec les nouvelles données
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date ? Carbon::parse($request->start_date) : null,
            'duration' => $request->duration,
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
}
