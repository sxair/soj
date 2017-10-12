<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOjProblemInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oj_problem_infos', function (Blueprint $table) {
            $table->unsignedInteger('id');
//            $table->integer('submit');
//            $table->integer('ac');
            // get in oj_problmes
            $table->unsignedInteger('ac_user')->default(0);
            $table->unsignedInteger('pe')->default(0);
            $table->unsignedInteger('wa')->default(0);
            $table->unsignedInteger('ce')->default(0);
            $table->unsignedInteger('re')->default(0);
            $table->unsignedInteger('tle')->default(0);
            $table->unsignedInteger('ole')->default(0);
            $table->unsignedInteger('mle')->default(0);
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oj_problem_infos');
    }
}
