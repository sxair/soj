<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('problem_id')->index();
            $table->tinyInteger('lang');
            $table->string('user_name', 20)->index();
            $table->unsignedInteger('status')->default(0)->index();
            $table->integer('time')->default(0);
            $table->integer('memory')->default(0);
            $table->integer('code_len');
            $table->text('code');
            $table->text('ce');
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
        Schema::dropIfExists('admin_status');
    }
}
