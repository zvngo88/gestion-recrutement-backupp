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
        Schema::table('tracking_steps', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tracking_steps', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id')->nullable(false)->change();
        });
    }

};
