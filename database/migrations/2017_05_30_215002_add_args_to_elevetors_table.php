<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArgsToElevetorsTable extends Migration
{
    public function up()
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->string("storage");
            $table->string("storage-type");
            $table->string("metal-sylos");
            $table->string("dryers");
            $table->string("dryer-power");
            $table->string("filter");
            $table->string("filter-power");
            $table->string("transport");
            $table->string("transport-power");
            $table->string("aspiration");
            $table->string("car-reception");
            $table->string("car-reception-power");
            $table->string("rail-reception");
            $table->string("rail-reception-power");
            $table->string("embarkation");
            $table->string("embarkation-power");
            $table->string("loader-icon");
            $table->string("fumigation");
            $table->string("certification");
            $table->string("developer");
            $table->string("automatization");
            $table->string("building");
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
            $table->dropColumn("storage");
            $table->dropColumn("storage-type");
            $table->dropColumn("metal-sylos");
            $table->dropColumn("dryers");
            $table->dropColumn("dryer-power");
            $table->dropColumn("filter");
            $table->dropColumn("filter-power");
            $table->dropColumn("transport");
            $table->dropColumn("transport-power");
            $table->dropColumn("aspiration");
            $table->dropColumn("car-reception");
            $table->dropColumn("car-reception-power");
            $table->dropColumn("rail-reception");
            $table->dropColumn("rail-reception-power");
            $table->dropColumn("embarkation");
            $table->dropColumn("embarkation-power");
            $table->dropColumn("loader-icon");
            $table->dropColumn("fumigation");
            $table->dropColumn("certification");
            $table->dropColumn("developer");
            $table->dropColumn("automatization");
            $table->dropColumn("building");
        });
    }
}
