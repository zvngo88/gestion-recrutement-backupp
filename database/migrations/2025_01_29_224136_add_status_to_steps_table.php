<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToStepsTable extends Migration
{
    public function up()
    {
        // Vérifier si la colonne 'status' n'existe pas déjà
        if (!Schema::hasColumn('steps', 'status')) {
            Schema::table('steps', function (Blueprint $table) {
                $table->string('status')->nullable()->after('name'); // Ajouter la colonne
            });
        }
    }

    public function down()
    {
        // Vérifier si la colonne 'status' existe avant de la supprimer
        if (Schema::hasColumn('steps', 'status')) {
            Schema::table('steps', function (Blueprint $table) {
                $table->dropColumn('status'); // Supprimer la colonne
            });
        }
    }
}
