<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrackingStep;

class TrackingStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                'name' => $step,
                'status' => 'pending',
                'assignment_id' => null, // S'assurer que cette colonne accepte les valeurs nulles
            ]);
        }
    }
}
