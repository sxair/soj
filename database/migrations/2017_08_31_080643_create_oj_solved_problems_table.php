<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOjSolvedProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oj_solved_problems', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('problem_id');
            $table->integer('submitted')->default(1);
            $table->integer('accepted')->default(0);
            $table->primary(['user_id','problem_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oj_solved_problems');
    }
}
