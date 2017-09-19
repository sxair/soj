<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contest_id');
            $table->char('problem_id')->index();
            $table->tinyInteger('lang')->index();
            $table->string('user_name')->index();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('status')->default(0)->index();
            $table->integer('time')->default(0);
            $table->integer('code_len');
            $table->integer('memory')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_status');
    }
}
