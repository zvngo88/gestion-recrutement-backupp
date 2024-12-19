<?php

namespace App\Http\Controllers;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
     // Afficher la liste des candidats
     public function index()
     {
         $candidates = Candidate::all();
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
}
