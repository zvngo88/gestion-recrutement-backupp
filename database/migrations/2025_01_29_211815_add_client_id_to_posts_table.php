<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToPostsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('posts', 'client_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->integer('client_id')->nullable();
            });
        }
    }


    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
}