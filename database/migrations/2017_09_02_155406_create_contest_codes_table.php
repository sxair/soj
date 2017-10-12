<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_codes', function (Blueprint $table) {
            $table->unsignedInteger('contest_id');
            $table->unsignedInteger('status_id');
            $table->text('code');
            $table->primary('contest_id', 'status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_codes');
    }
}
