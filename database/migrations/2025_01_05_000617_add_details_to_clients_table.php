<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        // Ajouter la colonne 'activity' si elle n'existe pas déjà
        if (!Schema::hasColumn('clients', 'activity')) {
            $table->string('activity')->nullable()->after('name');
        }

        // Ajouter la colonne 'contact_name' si elle n'existe pas déjà
        if (!Schema::hasColumn('clients', 'contact_name')) {
            $table->string('contact_name')->nullable()->after('activity');
        }

        // Ajouter la colonne 'contact_position' si elle n'existe pas déjà
        if (!Schema::hasColumn('clients', 'contact_position')) {
            $table->string('contact_position')->nullable()->after('contact_name');
        }

        // Ajouter la colonne 'contact_email' si elle n'existe pas déjà
        if (!Schema::hasColumn('clients', 'contact_email')) {
            $table->string('contact_email')->nullable()->unique()->after('contact_position');
        }

        // Ajouter la colonne 'contact_phone' si elle n'existe pas déjà
        if (!Schema::hasColumn('clients', 'contact_phone')) {
            $table->string('contact_phone')->nullable()->after('contact_email');
        }
    });
}
    

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'activity',
                'contact_name',
                'contact_position',
                'contact_email',
                'contact_phone',
                
            ]);
        });
    }

};
