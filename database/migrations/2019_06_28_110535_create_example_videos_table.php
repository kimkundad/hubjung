<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExampleVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string('course_video_name');
            $table->string('course_video_detail')->nullable();
            $table->string('course_video')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->string('course_video_url')->nullable();
            $table->string('time_video')->nullable();
            $table->integer('view_video')->default('0');
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
        Schema::drop('example_videos');
    }
}
