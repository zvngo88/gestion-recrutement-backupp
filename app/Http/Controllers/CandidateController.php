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
        $posts = Post::all(); // Charger tous les postes disponibles
        $assignments = Assignment::with(['post', 'candidate'])->get();

        return view('candidates.index', compact('candidates', 'posts', 'assignments'));
    }

    /**
     * Affiche les détails d'un candidat.
     */
    public function show($id)
    {
        // Récupère le candidat par son ID
        $candidate = Candidate::findOrFail($id); // Utilise findOrFail pour éviter les erreurs si le candidat n'existe pas

        // Vérifie si un fichier CV existe pour ce candidat et génère l'URL du fichier
        $cvUrl = $candidate->cv ? asset('storage/' . $candidate->cv) : null;

        // Passe le candidat et le lien vers le CV à la vue
        return view('candidates.show', compact('candidate', 'cvUrl'));
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
    public function storeAssignment(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'post_id' => 'required|exists:posts,id',
        ]);

        // Créer une nouvelle affectation
        $assignment = Assignment::create([
            'candidate_id' => $request->candidate_id,
            'post_id' => $request->post_id,
            'assigned_at' => now(),
        ]);

        // Créer les étapes pour cette affectation
        $this->createTrackingSteps($assignment->id);

        return redirect()->route('candidates.index')->with('success', 'Candidat affecté avec succès.');
    }





    public function assignments()
    {
        // Logique pour afficher les assignments
        return view('candidates.index');
    }

    /**
     * Suivi d'une affectation.
     */
    public function track($assignmentId)
    {
        // Charger l'affectation avec les relations 'candidate' et 'post'
        $assignment = Assignment::with(['candidate', 'post'])->findOrFail($assignmentId);

        // Charger les étapes associées à cette affectation
        $steps = TrackingStep::where('assignment_id', $assignmentId)->get();

        // Inclure le candidat
        $candidate = $assignment->candidate;

        // Retourner la vue 'track' avec les données récupérées
        return view('candidates.track', compact('assignment', 'steps', 'candidate'));
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
    
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public'); // Enregistre le fichier dans storage/app/public/cv
        } else {
            $cvPath = null;
        }
    
        $candidate = Candidate::create([
            'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'current_position' => $validatedData['current_position'],
            'current_company' => $validatedData['current_company'],
            'skills' => $validatedData['skills'],
            'education' => $validatedData['education'],
            'school' => $validatedData['school'],
            'nationality' => $validatedData['nationality'],
            'status' => $validatedData['status'],
            
        ]);
    
        // Vérifie si le CV a été téléchargé
        $cvUrl = $cvPath ? asset('storage/' . $cvPath) : null;
    
        // Redirige avec un message et passe le lien du CV
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
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'status' => 'required|string|in:Disponible,Affecté',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validation du fichier CV
        ]);

        // Gestion du CV
        if ($request->hasFile('cv')) {
            $filename = time() . '_' . $request->file('cv')->getClientOriginalName();
            $request->file('cv')->move(public_path('uploads/cv'), $filename); // Sauvegarde dans public/uploads/cv
            $candidate->cv = 'uploads/cv/' . $filename; // Met à jour le chemin du fichier CV
        }

        // Mettre à jour les autres champs
        $candidate->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'current_position' => $validatedData['current_position'],
            'current_company' => $validatedData['current_company'],
            'skills' => $validatedData['skills'],
            'education' => $validatedData['education'],
            'school' => $validatedData['school'],
            'nationality' => $validatedData['nationality'],
            'status' => $validatedData['status'],
        ]);

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
    
    /**
     * Met à jour les étapes de suivi.
     */
    public function updateTracking(Request $request, $assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);

        // Valider les données
        $validatedData = $request->validate([
            'steps.*.id' => 'required|exists:tracking_steps,id',
            'steps.*.status' => 'required|in:OK,NotOK',
            'steps.*.reason' => 'nullable|string|max:255',
        ]);

        // Mettre à jour chaque étape
        foreach ($validatedData['steps'] as $stepData) {
            $step = TrackingStep::findOrFail($stepData['id']);
            $step->update([
                'status' => $stepData['status'],
                'reason' => $stepData['status'] === 'NotOK' ? $stepData['reason'] : null,
            ]);
        }

        return redirect()->route('assignments.track', $assignmentId)
            ->with('success', 'Étapes enregistrées avec succès.');
    }

    public function updateSteps(Request $request, $candidateId)
    {
        // Validez les données du formulaire
        $request->validate([
            'status.*' => 'required|in:ok,notok',
            'reason.*' => 'nullable|string|max:255',
        ]);

        // Récupérer l'affectation et le candidat
        $assignment = Assignment::with('candidate')->where('candidate_id', $candidateId)->first();
        
        if (!$assignment) {
            return redirect()->back()->with('error', 'Affectation introuvable.');
        }

        // Récupérer le candidat associé à l'affectation
        $candidate = $assignment->candidate;

        // Récupérer les étapes associées à cette affectation
        $steps = TrackingStep::where('assignment_id', $assignment->id)->get();

        // Vérifier que $request->status est bien un tableau
        if (is_array($request->status) || is_object($request->status)) {
            // Logique pour mettre à jour les étapes
            foreach ($request->status as $index => $status) {
                $step = TrackingStep::where('assignment_id', $assignment->id)->skip($index)->first();
                if ($step) {
                    $step->update([
                        'status' => $status,
                        'reason' => $request->reason[$index] ?? null,
                    ]);
                }
            }
        } else {
            // Si $request->status n'est pas un tableau, vous pouvez gérer le cas ici
            return redirect()->back()->with('error', 'Les données de statut sont invalides.');
        }

        // Retourner la vue avec les étapes mises à jour et l'affectation du candidat
        return view('candidates.track', compact('assignment', 'steps', 'candidate'))
            ->with('success', 'Étapes mises à jour avec succès.');
    }







    private function createTrackingSteps($assignmentId)
    {
        $defaultSteps = [
            'Étape 1: Préselection',
            'Étape 2: Premier contact',
            'Étape 3.1: 1er entretien',
            'Étape 3.2: 2e entretien',
            'Étape 3.3: Évaluation',
            'Étape 4: Qualification de la candidature',
            'Étape 5: Présentation à l\'entreprise',
            'Étape 6: Confirmation candidature',
        ];

        foreach ($defaultSteps as $step) {
            TrackingStep::create([
                'assignment_id' => $assignmentId,
                'name' => $step,
                'status' => 'pending', // Par défaut, toutes les étapes sont en attente
            ]);
        }
    }


    public function showAssignment($assignmentId)
    {
        $assignment = Assignment::with('candidate', 'post', 'steps')->findOrFail($assignmentId);

        return view('assignments.show', [
            'assignment' => $assignment,
            'steps' => $assignment->steps,
        ]);
    }

    public function uploadCv(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048', // Valide le fichier
        ]);

        // Récupère le candidat par son ID
        $candidate = Candidate::findOrFail($id);

        // Générer un nom de fichier unique
        $fileName = 'candidate_' . $id . '_' . time() . '.' . $request->file('cv')->getClientOriginalExtension();

        // Gère l'upload du fichier CV
        if ($request->hasFile('cv')) {
            // Supprime l'ancien fichier si nécessaire
            if ($candidate->cv) {
                Storage::disk('public')->delete($candidate->cv);
            }

            // Stocke le nouveau fichier avec un nom personnalisé
            $cvPath = $request->file('cv')->storeAs('cvs', $fileName, 'public');

            // Met à jour le chemin du fichier dans la base de données
            $candidate->update(['cv' => $cvPath]);
        }

        return redirect()->back()->with('success', 'CV téléchargé avec succès.');
    }






}