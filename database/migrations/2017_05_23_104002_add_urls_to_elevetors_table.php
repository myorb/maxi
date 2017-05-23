<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlsToElevetorsTable extends Migration
{
    public function up()
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->string('pars_url');
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->dropColumn('pars_url');
            $table->dropColumn('note');
        });
    }
}
