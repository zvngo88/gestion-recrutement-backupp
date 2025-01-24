<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tracking_steps', function (Blueprint $table) {
            $table->id();
            // Vérifie si la table assignments existe
            if (Schema::hasTable('assignments')) {
                $table->unsignedBigInteger('assignment_id');
                $table->foreignId('assignment_id')->nullable()->constrained()->onDelete('cascade'); // Ajout de nullable()
            }

            $table->string('name'); // Nom de l'étape
            $table->string('status')->default('pending'); // Statut par défaut
            $table->string('reason')->nullable(); // Raison si 'notok'
            $table->timestamps();

            // Contrainte de clé étrangère
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_steps');
    }
};
