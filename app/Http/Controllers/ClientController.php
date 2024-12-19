<?php

namespace App\Http\Controllers;

use App\Models\Client; // Utilise le modèle Eloquent Client
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    // Afficher la liste des clients
    public function index()
    {
        // Récupère tous les clients de la base de données
        $clients = Client::all();  // Utilisation correcte du modèle Eloquent

        // Retourne la vue avec les clients
        return view('clients.index', compact('clients'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('clients.create');
    }

    // Enregistrer un nouveau client
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // Crée un nouveau client dans la base de données
        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $client = Client::findOrFail($id);  // Récupère un client par ID
        return view('clients.edit', compact('client'));
    }

    // Mettre à jour un client existant
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // Mise à jour des données du client
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    // Supprimer un client
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
