<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('title', 50);
            $table->integer('time_limit');
            $table->integer('judge_cnt');
            $table->integer('memory_limit');
            $table->tinyInteger('spj');
            $table->text('content');
            $table->text('input');
            $table->text('output');
            $table->text('sample_input');
            $table->text('sample_output');
            $table->text('hint')->nullable();
            $table->string('author', 50)->nullable()->index();
            $table->string('source', 50)->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('difficulty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problems');
    }
}
