<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Candidate;
use App\Models\Post;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Http\Controllers\Controller;


class InterviewController extends Controller {
    // Afficher le formulaire de planification
    public function create() {
        $clients = Client::all();
        $posts = Post::all();
        $candidates = Candidate::all();
        return view('interviews.create', compact('clients', 'posts', 'candidates'));
    }

    // Enregistrer l'entretien
    public function store(Request $request) {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'post_id' => 'required|exists:posts,id',
            'candidate_id' => 'required|exists:candidates,id',
            'interview_date' => 'required|date',
        ]);

        Interview::create($request->all());

        return redirect()->route('interviews.index')->with('success', 'Entretien planifié avec succès.');
    }


    public function index(Request $request)
    {
        $interviews = Interview::with(['client', 'post', 'candidate'])
            ->when($request->filled('search_client'), function ($query) use ($request) {
                $query->whereHas('client', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search_client . '%');
                });
            })
            ->when($request->filled('search_post'), function ($query) use ($request) {
                $query->whereHas('post', function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search_post . '%');
                });
            })
            ->when($request->filled('search_candidate'), function ($query) use ($request) {
                $query->whereHas('candidate', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search_candidate . '%');
                });
            })
            ->get();
    
        $clients = Client::all();
        $posts = Post::all();
        $candidates = Candidate::all();
    
        return view('interviews.index', compact('interviews', 'clients', 'posts', 'candidates'));
    }

    public function sendOutlookEmail($id)
    {
        $interview = Interview::with('client', 'candidate')->findOrFail($id);

        // Lien pour ouvrir Outlook avec les détails
        $subject = urlencode("Entretien prévu avec {$interview->candidate->name}");
        $body = urlencode("Bonjour,\n\nVotre entretien est prévu le {$interview->interview_date->format('d/m/Y à H:i')} avec {$interview->client->name}.\n\nCordialement,\nL'équipe RH");
        $to = $interview->candidate->email;

        return redirect("mailto:$to?subject=$subject&body=$body");
    }

    public function getPostsByClient($clientId)
    {
        $posts = Post::where('client_id', $clientId)->get(['id', 'title']); // Renvoie les ID et titres des postes
        return response()->json($posts);
    }

    public function getCandidatesByPost($postId)
    {
        try {
            // Vérifie les affectations pour un poste donné, avec la relation "candidate" chargée
            $assignments = Assignment::where('post_id', $postId)
                                    ->with('candidate') // Récupère les candidats associés via la relation
                                    ->get();

            // Vérifie s'il y a des affectations pour ce poste
            if ($assignments->isEmpty()) {
                return response()->json(['message' => 'Aucun candidat affecté à ce poste'], 404);
            }

            // Si des affectations sont trouvées, extraire seulement les candidats
            $candidates = $assignments->map(function ($assignment) {
                return $assignment->candidate; // Renvoie uniquement le candidat associé à l'affectation
            });

            return response()->json($candidates); // Renvoie les candidats sous forme de JSON
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
