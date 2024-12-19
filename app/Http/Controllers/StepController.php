<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Step;
use App\Models\Candidate;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function index(Post $post)
    {
        // Récupérer les étapes du poste
        $steps = $post->steps;
        return view('steps.index', compact('post', 'steps'));
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

        // Validation des champs pour la mise à jour de l'étape
        $request->validate([
            'status' => 'nullable|boolean',  // Accepte un status null ou un boolean
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'justification' => 'nullable|string', // Validation pour la justification
        ]);

        // Convertir la valeur en boolean (si null ou non défini, mettre false)
        $status = $request->has('status') ? (bool) $request->input('status') : false;

        // Mise à jour du modèle Step
        $step->update([
            'status' => $status,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'justification' => $request->input('justification'), // Mise à jour de la justification
        ]);

        return back()->with('success', 'Étape mise à jour avec succès.');
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
