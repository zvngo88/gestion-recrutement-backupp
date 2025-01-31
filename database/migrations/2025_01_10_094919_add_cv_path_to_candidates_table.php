<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCvPathToCandidatesTable extends Migration
{
    public function up()
    {
        // Vérifier si la colonne 'cv_path' n'existe pas déjà
        if (!Schema::hasColumn('candidates', 'cv_path')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->string('cv_path')->nullable()->after('email'); // Ajouter la colonne
            });
        }
    }

    public function down()
    {
        // Vérifier si la colonne 'cv_path' existe avant de la supprimer
        if (Schema::hasColumn('candidates', 'cv_path')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->dropColumn('cv_path'); // Supprimer la colonne
            });
        }
    }
}