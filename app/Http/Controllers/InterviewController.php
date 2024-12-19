<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class InterviewController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $candidates = Candidate::all();
        $interviews = Interview::with('client', 'candidate')->get();

        return view('interviews.index', compact('clients', 'candidates', 'interviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'candidate_id' => 'required|exists:candidates,id',
            'interview_date' => 'required|date',
        ]);

        Interview::create($request->all());

        return redirect()->route('interviews.index')->with('success', 'Entretien planifié avec succès.');
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
}
