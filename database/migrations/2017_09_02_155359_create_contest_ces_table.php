<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestCesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_ces', function (Blueprint $table) {
            $table->unsignedInteger('contest_id');
            $table->unsignedInteger('status_id');
            $table->text('content');
            $table->primary('contest_id','status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_ces');
    }
}
