<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string('course_video_name');
            $table->text('course_video');
            $table->integer('order_sort');
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
        Schema::drop('video_lists');
    }
}
