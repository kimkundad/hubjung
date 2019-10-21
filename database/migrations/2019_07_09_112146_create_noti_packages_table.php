<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noti_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default('0');
            $table->string('name_noti')->nullable();
            $table->string('url_noti')->nullable();
            $table->integer('noti_read')->default('0');
            $table->integer('new_status')->default('0');
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
        Schema::drop('noti_packages');
    }
}
