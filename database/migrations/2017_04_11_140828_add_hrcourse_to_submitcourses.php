<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHrcourseToSubmitcourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('submitcourses', function($table) {
      $table->integer('hrcourse');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('submitcourses', function($table) {
      $table->dropColumn('hrcourse');
      });
    }
}
