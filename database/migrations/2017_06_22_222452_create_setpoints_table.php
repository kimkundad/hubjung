<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examples_id_p');
            $table->integer('id_option_p');
            $table->integer('user_id');
            $table->integer('status_p');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('setpoints');
    }
}
