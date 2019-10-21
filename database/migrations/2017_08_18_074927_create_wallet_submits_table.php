<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletSubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_submits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_id');
            $table->integer('user_id');
            $table->integer('status');
            $table->integer('bank_id');
            $table->integer('money_user');
            $table->date('date_transfer');
            $table->string('time_transfer');
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
        Schema::drop('wallet_submits');
    }
}
