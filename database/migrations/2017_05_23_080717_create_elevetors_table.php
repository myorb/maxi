<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElevetorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elevators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('basic_info');
            $table->string('elevator_company');
            $table->string('elevator_start_date');
            $table->string('elevator_boss');
            $table->string('elevator_type');
            $table->string('basic_logo');
            $table->text('additional_info');
            $table->text('html');
            $table->integer('url_id');
            $table->string('address');
            $table->string('link');
            $table->string('phone');
            $table->string('email');
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
        Schema::drop('elevators');
    }
}
