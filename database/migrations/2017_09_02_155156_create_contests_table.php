<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->index();
            $table->timestamp('start_time');
            // two timestamp no default will be wrong
            $table->timestamp('end_time')->nullable();
            $table->string('password')->default('');
            $table->unsignedInteger('lang')->default(0);
            $table->string('choose')->nullable();
            $table->string('user_name', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
