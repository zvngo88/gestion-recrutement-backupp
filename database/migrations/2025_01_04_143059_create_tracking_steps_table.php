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
            $table->unsignedBigInteger('assignment_id'); // Définissez cette colonne UNE SEULE FOIS
            $table->string('name');
            $table->string('status')->default('pending');
            $table->string('reason')->nullable();
            $table->timestamps();

            // Ajoutez une seule contrainte de clé étrangère
            $table->foreign('assignment_id')
                ->references('id')
                ->on('assignments')
                ->onDelete('cascade');
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
