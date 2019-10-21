<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_name')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('package_day')->nullable();
            $table->float('package_price')->nullable();
            $table->integer('package_sort')->nullable();
            $table->string('package_image')->nullable();
            $table->integer('package_status')->default('0');
            $table->integer('package_type')->default('0');
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
        Schema::drop('package_products');
    }
}
