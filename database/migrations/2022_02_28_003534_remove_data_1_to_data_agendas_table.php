<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveData1ToDataAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_agendas', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('place_of_birth');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('profession');
            $table->dropColumn('address');
            $table->dropColumn('religion');
            $table->dropColumn('education');
            $table->dropColumn('status');
            $table->dropColumn('necessity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_agendas', function (Blueprint $table) {
            //
        });
    }
}
