<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Step;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    // Afficher la liste des candidats
    public function index(Request $request)
    {
        $query = Candidate::query();

        // Recherche par les données du candidat (nom, email, etc.)
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $candidates = $query->get();

        return view('candidates.index', compact('candidates'));
    }

    // Afficher le formulaire pour ajouter un candidat
    public function create()
    {
        return view('candidates.create');
    }

    // Sauvegarder un nouveau candidat
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'status' => 'required|string',
            'skills' => 'nullable|string',
        ]);

        Candidate::create($request->all());
        return redirect()->route('candidates.index')->with('success', 'Candidat créé avec succès');
    }

    // Afficher un candidat spécifique
    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    // Afficher le formulaire de modification d'un candidat
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    // Mettre à jour un candidat
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'status' => 'required|string',
            'skills' => 'nullable|string',
        ]);

        $candidate->update($request->all());
        return redirect()->route('candidates.index')->with('success', 'Candidat mis à jour avec succès');
    }

    // Supprimer un candidat
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidat supprimé avec succès');
    }

    // Afficher la page d'affectation d'un candidat à un poste
    public function assign(Candidate $candidate)
    {
        $posts = Post::all(); // Liste des postes disponibles
        return view('candidates.assign', compact('candidate', 'posts'));
    }

    // Sauvegarder l'affectation d'un candidat à un poste
    public function storeAssignment(Request $request, Candidate $candidate)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id', // Validation du poste
        ]);

        // Créer une nouvelle affectation
        $candidate->posts()->attach($request->post_id);

        // Mettre à jour le statut du candidat après affectation
        $candidate->update(['status' => 'Affecté']);

        return redirect()->route('candidates.index')->with('success', 'Candidat affecté au poste avec succès.');
    }

    // Afficher les étapes du suivi du candidat pour un poste spécifique
    public function showSteps(Candidate $candidate, Post $post)
    {
        // Récupérer les étapes du poste pour le candidat affecté
        $steps = $post->steps;
        $assignment = $candidate->posts()->where('post_id', $post->id)->first()->pivot; // Récupérer l'affectation spécifique

        return view('steps.show', compact('candidate', 'post', 'steps', 'assignment'));
    }

    // Mettre à jour le statut d'une étape du candidat
    public function updateStepStatus(Request $request, Candidate $candidate, Post $post, Step $step)
    {
        $request->validate([
            'status' => 'nullable|boolean',
            'justification' => 'nullable|string|max:255',
        ]);

        // Trouver l'affectation
        $assignment = $candidate->posts()->where('post_id', $post->id)->first()->pivot;

        // Mettre à jour l'étape spécifique du candidat
        $assignment->steps()->updateExistingPivot($step->id, [
            'status' => $request->status ?? false, // Par défaut "NotOK" si non fourni
            'justification' => $request->justification,
        ]);

        return back()->with('success', 'Statut de l\'étape mis à jour avec succès.');
    }
}
