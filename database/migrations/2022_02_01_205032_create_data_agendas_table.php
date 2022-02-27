<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_agenda');
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender',['pria','wanita']);
            $table->string('profession');
            $table->string('address');
            $table->string('religion');
            $table->string('education');
            $table->string('status');
            $table->string('necessity');
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
        Schema::dropIfExists('data_agendas');
    }
}
