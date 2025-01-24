<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('activity')->nullable()->after('name');
            $table->string('contact_name')->nullable()->after('activity');
            $table->string('contact_position')->nullable()->after('contact_name');
            $table->string('contact_email')->nullable()->unique()->after('contact_position');
            $table->string('contact_phone')->nullable()->after('contact_email');
            
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
