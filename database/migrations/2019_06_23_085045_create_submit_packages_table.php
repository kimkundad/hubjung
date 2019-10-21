<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmitPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submit_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('packeage_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('total_day')->default('0');
            $table->date('start');
            $table->date('end_date');
            $table->integer('sp_status')->default('0');
            $table->integer('submit_type')->default('0');
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
        Schema::drop('submit_packages');
    }
}
