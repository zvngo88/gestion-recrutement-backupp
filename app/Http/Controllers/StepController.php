<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function index(Post $post)
    {
        $steps = $post->steps;
        return view('steps.index', compact('post', 'steps'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $post->steps()->create($request->only('name', 'start_date', 'end_date'));

        return back()->with('success', 'Étape ajoutée avec succès.');
    }

    public function update(Request $request, $postId, $stepId)
{
    // Récupérer le modèle Post et Step manuellement
    $post = Post::findOrFail($postId);  // Récupérer le Post
    $step = Step::where('post_id', $post->id)->findOrFail($stepId);  // Récupérer le Step associé au Post

    // Validation des données
    $request->validate([
        'status' => 'boolean',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    // Mettre à jour le modèle Step
    $step->update($request->only('status', 'start_date', 'end_date'));

    // Retourner un message de succès
    return back()->with('success', 'Étape mise à jour avec succès.');
}

}
