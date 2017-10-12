<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_problems', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->unsignedInteger('problem_id');
            $table->unsignedInteger('user_id');
            $table->boolean('public');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_problems');
    }
}
