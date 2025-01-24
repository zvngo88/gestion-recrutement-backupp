<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentTrackingStepTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assignment_tracking_step', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('step_id');

            // Statut et raison
            $table->enum('status', ['OK', 'NotOK'])->default('OK');
            $table->string('reason')->nullable();

            // Dates
            $table->timestamps();

            // Contraintes d'intégrité référentielle
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('step_id')->references('id')->on('tracking_steps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assignment_tracking_step');
    }
}
