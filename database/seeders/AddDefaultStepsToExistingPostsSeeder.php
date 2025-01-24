<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class AddDefaultStepsToExistingPostsSeeder extends Seeder
{
    public function run()
    {
        // Définition des étapes par défaut
        $defaultSteps = [
            [
                'name' => 'Création du poste et finalisation de la CDC',
                'start_date' => now(),
                'end_date' => now()->addDays(7),
                'status' => 'En cours',
            ],
            [
                'name' => 'Sourcing',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(14),
                'status' => 'En cours',
            ],
            [
                'name' => 'Analyse des profils',
                'start_date' => now()->addDays(14),
                'end_date' => now()->addDays(21),
                'status' => 'En cours',
            ],
            [
                'name' => 'Shortliste',
                'start_date' => now()->addDays(21),
                'end_date' => now()->addDays(28),
                'status' => 'En cours',
            ],
            [
                'name' => 'Entretien entreprise',
                'start_date' => now()->addDays(28),
                'end_date' => now()->addDays(35),
                'status' => 'En cours',
            ],
            [
                'name' => 'Sélection',
                'start_date' => now()->addDays(35),
                'end_date' => now()->addDays(42),
                'status' => 'En cours',
            ],
            [
                'name' => 'Confirmation du candidat',
                'start_date' => now()->addDays(42),
                'end_date' => now()->addDays(49),
                'status' => 'En cours',
            ],
            [
                'name' => 'Clôture de la mission',
                'start_date' => now()->addDays(49),
                'end_date' => now()->addDays(56),
                'status' => 'En cours',
            ],
        ];

        // Récupération de tous les postes existants
        $posts = Post::all();

        foreach ($posts as $post) {
            foreach ($defaultSteps as $step) {
                // Vérifie si l'étape existe déjà pour éviter les doublons
                $existingStep = $post->steps()->where('name', $step['name'])->first();

                if (!$existingStep) {
                    $post->steps()->create($step);
                }
            }
        }
    }
}
