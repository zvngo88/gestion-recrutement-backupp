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

    
   

     public function index(Request $request)
     {
         $searchCandidate = $request->input('search'); // Recherche pour les candidats
         $searchPost = $request->input('search_post'); // Recherche pour les affectations (poste)
         $searchAssignmentCandidate = $request->input('search_candidate'); // Recherche pour les affectations (candidat)
 
         // Recherche sur les candidats
         $candidates = Candidate::query()
             ->when($searchCandidate, function ($query, $searchCandidate) {
                 return $query->where('first_name', 'like', "%{$searchCandidate}%")
                             ->orWhere('last_name', 'like', "%{$searchCandidate}%")
                             ->orWhere('email', 'like', "%{$searchCandidate}%")
                             ->orWhere('phone', 'like', "%{$searchCandidate}%")
                             ->orWhere('address', 'like', "%{$searchCandidate}%")
                             ->orWhere('current_position', 'like', "%{$searchCandidate}%")
                             ->orWhere('current_company', 'like', "%{$searchCandidate}%")
                             ->orWhere('skills', 'like', "%{$searchCandidate}%")
                             ->orWhere('school', 'like', "%{$searchCandidate}%")
                             ->orWhere('nationality', 'like', "%{$searchCandidate}%");
             })
             ->paginate(10, ['*'], 'candidates_page'); // 'candidates_page' est le nom du paramètre de pagination
 
         // Recherche sur les affectations par poste et candidat
         $assignments = Assignment::with(['post', 'candidate'])
             ->when($searchPost, function ($query, $searchPost) {
                 return $query->whereHas('post', function ($q) use ($searchPost) {
                     $q->where('title', 'like', "%{$searchPost}%");
                 });
             })
             ->when($searchAssignmentCandidate, function ($query, $searchAssignmentCandidate) {
                 return $query->whereHas('candidate', function ($q) use ($searchAssignmentCandidate) {
                     $q->where('first_name', 'like', "%{$searchAssignmentCandidate}%")
                       ->orWhere('last_name', 'like', "%{$searchAssignmentCandidate}%");
                 });
             })
             ->paginate(10, ['*'], 'assignments_page'); // 'assignments_page' est le nom du paramètre de pagination
 
         $posts = Post::all();
 
         return view('candidates.index', compact('candidates', 'assignments', 'posts'));
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
            $validatedData['cv'] = $cvPath; // Ajoute le chemin du fichier aux données validées
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
            'history' => 'nullable|string', // Validation du champ historique
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
            'history' => $validatedData['history'], // Mise à jour du champ historique
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
        // Valider les données du formulaire
        $request->validate([
            'status.*' => 'required|in:ok,notok',
            'reason.*' => 'nullable|string|max:255',
        ], [
            'status.*.required' => 'Le statut est obligatoire pour chaque étape.',
            'status.*.in' => 'Le statut doit être "ok" ou "notok".',
            'reason.*.max' => 'La raison ne doit pas dépasser 255 caractères.',
        ]);

        // Récupérer l'affectation et le candidat
        $assignment = Assignment::with('candidate')->where('candidate_id', $candidateId)->first();

        if (!$assignment) {
            return redirect()->back()->with('error', 'Affectation introuvable.');
        }

        // Récupérer les étapes associées à cette affectation
        $steps = TrackingStep::where('assignment_id', $assignment->id)->get();

        // Mettre à jour chaque étape
        foreach ($steps as $index => $step) {
            $status = $request->status[$index] ?? null;
            $reason = $request->reason[$index] ?? null;

            if ($status) {
                $step->update([
                    'status' => $status,
                    'reason' => $reason,
                ]);
            }
        }

        
            // Si la requête est standard, rediriger avec un message de succès
        return redirect()->route('candidates.track', $candidateId)
            ->with('success', 'Étapes mises à jour avec succès.')
            ->with('assignment', $assignment)
            ->with('steps', $steps);
        
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

    public function searchPosts(Request $request)
    {
        $query = $request->input('q', ''); // Terme de recherche
        $posts = Post::where('title', 'LIKE', "%$query%")
            ->paginate(10); // Pagination si nécessaire

        return response()->json([
            'items' => $posts->items(),
            'pagination' => [
                'more' => $posts->hasMorePages()
            ]
        ]);
    }







}