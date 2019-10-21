<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageHisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_his', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('packeage_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->float('discount')->nullable();
            $table->integer('his_status')->default('0');
            $table->integer('his_type')->default('0');
            $table->integer('bank_id')->nullable();
            $table->float('money_tran')->nullable();
            $table->string('slip_img')->nullable();
            $table->string('date_tran')->nullable();
            $table->string('time_tran')->nullable();
            $table->date('start');
            $table->date('end_date');
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
        Schema::drop('package_his');
    }
}
