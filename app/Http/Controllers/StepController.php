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
        $post = Post::findOrFail($postId);
        $step = Step::where('post_id', $post->id)->findOrFail($stepId);

        $request->validate([
            'status' => 'nullable|boolean',  // Accepte un status null ou un boolean
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Convertir la valeur en boolean (si null ou non défini, mettre false)
        $status = $request->has('status') ? (bool) $request->input('status') : false;

        // Mettre à jour le modèle Step
        $step->update([
            'status' => $status,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        return back()->with('success', 'Étape mise à jour avec succès.');
    }


}
