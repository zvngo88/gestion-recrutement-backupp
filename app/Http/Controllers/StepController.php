<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Step;
use App\Models\Candidate;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $candidates = $post->candidates;  // Assurez-vous que la relation est bien définie
        $steps = Step::where('post_id', $post->id)
                     ->orderBy('order', 'asc') // Trie les étapes : d'abord celles non activées, puis celles activées
                     ->get();

        return view('steps.index', compact('post', 'steps', 'candidates'));
    }

    public function store(Request $request, Post $post)
    {
        // Validation pour l'ajout d'une étape
        $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Création de la nouvelle étape pour le poste
        $post->steps()->create($request->only('name', 'start_date', 'end_date'));

        return back()->with('success', 'Étape ajoutée avec succès.');
    }

    public function update(Request $request, $postId, $stepId)
    {
        $post = Post::findOrFail($postId);
        $step = Step::where('post_id', $post->id)->findOrFail($stepId);

        $request->validate([
            'status' => 'nullable|string|in:ok,notok',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'justification' => 'nullable|string',
        ]);

        $step->update([
            'status' => $request->input('status', $step->status),
            'start_date' => $request->input('start_date', $step->start_date),
            'end_date' => $request->input('end_date', $step->end_date),
            'justification' => $request->input('justification', $step->justification),
        ]);

        return redirect()->route('steps.index', ['post' => $post->id])->with('success', 'Étape mise à jour avec succès.');
    }



    public function show(Post $post, Candidate $candidate)
    {
        // Récupérer les étapes du poste
        $steps = $post->steps;

        // Vérifier l'affectation du candidat à ce poste
        $assignment = $candidate->posts()->where('post_id', $post->id)->first();

        if (!$assignment) {
            return redirect()->route('candidates.index')->with('error', 'Le candidat n\'est pas affecté à ce poste.');
        }

        // Récupérer les étapes associées à ce poste et le candidat
        return view('steps.show', compact('steps', 'candidate', 'post'));
    }
}