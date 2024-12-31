<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Post;
use App\Models\Assignment;
use App\Models\TrackingStep;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Liste des candidats.
     */
    public function index()
    {
        $candidates = Candidate::all();
        return view('candidates.index', compact('candidates'));
    }

    /**
     * Affiche les détails d'un candidat.
     */
    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    /**
     * Page pour affecter un candidat à un poste.
     */
    public function assign(Candidate $candidate)
    {
        $posts = Post::all(); // Liste des postes disponibles
        return view('candidates.assign', compact('candidate', 'posts'));
    }

    /**
     * Enregistre une affectation.
     */
    public function storeAssignment(Request $request, Candidate $candidate)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        Assignment::create([
            'candidate_id' => $candidate->id,
            'post_id' => $request->post_id,
            'assigned_at' => now(),
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidat affecté avec succès.');
    }

    /**
     * Suivi d'une affectation.
     */
    public function track($assignmentId)
    {
        $assignment = Assignment::with(['candidate', 'post'])->findOrFail($assignmentId);
        return view('assignments.track', compact('assignment'));
    }

    /**
     * Crée un nouveau candidat.
     */
    public function create()
    {
        return view('candidates.create');
    }

    /**
     * Enregistre un candidat.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'status' => 'required|string|in:Disponible,Affecté',
        ]);

        $candidate = Candidate::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'current_position' => $request->current_position,
            'current_company' => $request->current_company,
            'skills' => $request->skills,
            'education' => $request->education,
            'school' => $request->school,
            'nationality' => $request->nationality,
            'status' => $request->status,
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidat créé avec succès.');
    }

    /**
     * Modifie un candidat.
     */
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    /**
     * Met à jour un candidat.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'current_position' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'status' => 'required|string|in:Disponible,Affecté',
        ]);

        $candidate->update($request->all());

        return redirect()->route('candidates.index')->with('success', 'Candidat mis à jour avec succès.');
    }

    /**
     * Supprime un candidat.
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidat supprimé avec succès.');
    }

    /**
     * Suivi d'un candidat.
     */
    public function trackCandidate(Candidate $candidate)
    {
        $trackingSteps = $candidate->trackingSteps; // Étapes de suivi
        return view('candidates.track', compact('candidate', 'trackingSteps'));
    }

    /**
     * Enregistrement ou mise à jour du suivi d'un candidat.
     */
    public function storeTracking(Request $request, Candidate $candidate)
    {
        $request->validate([
            'step_id' => 'required|exists:tracking_steps,id',
            'status' => 'required|in:OK,NotOK',
            'reason' => 'nullable|string|max:255',
        ]);

        $candidate->trackingSteps()->updateOrCreate(
            ['step_id' => $request->step_id],
            [
                'status' => $request->status,
                'reason' => $request->reason,
                'updated_at' => now(),
            ]
        );

        return redirect()->route('candidates.track', $candidate->id)
            ->with('success', 'Étape enregistrée avec succès.');
    }
}
