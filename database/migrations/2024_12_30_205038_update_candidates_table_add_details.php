<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCandidatesTableAddDetails extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            if (!Schema::hasColumn('candidates', 'first_name')) {
                $table->string('first_name')->default('')->after('id');
            }
            if (!Schema::hasColumn('candidates', 'last_name')) {
                $table->string('last_name')->default('')->after('first_name');
            }
            if (!Schema::hasColumn('candidates', 'email')) {
                $table->string('email')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('candidates', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('candidates', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('candidates', 'current_position')) {
                $table->string('current_position')->nullable()->after('address');
            }
            if (!Schema::hasColumn('candidates', 'current_company')) {
                $table->string('current_company')->nullable()->after('current_position');
            }
            if (!Schema::hasColumn('candidates', 'skills')) {
                $table->text('skills')->nullable()->after('current_company');
            }
            if (!Schema::hasColumn('candidates', 'cv')) {
                $table->string('cv')->nullable()->after('skills');
            }
            if (!Schema::hasColumn('candidates', 'education')) {
                $table->string('education')->nullable()->after('cv');
            }
            if (!Schema::hasColumn('candidates', 'school')) {
                $table->string('school')->nullable()->after('education');
            }
            if (!Schema::hasColumn('candidates', 'nationality')) {
                $table->string('nationality')->nullable()->after('school');
            }
        });
    }

    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'current_position',
                'current_company',
                'skills',
                'cv',
                'education',
                'school',
                'nationality',
            ]);
        });
    }
}
