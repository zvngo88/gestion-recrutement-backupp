<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        // Vérifier si la table 'posts' n'existe pas déjà
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->date('start_date');
                $table->integer('duration');
                $table->string('status')->check("status IN ('Actif', 'Inactif')");
                $table->foreignId('client_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Vérifier si la table 'posts' existe avant de la supprimer
        if (Schema::hasTable('posts')) {
            Schema::dropIfExists('posts');
        }
    }
}