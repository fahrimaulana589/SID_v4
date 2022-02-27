<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenduduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('NIK')->unique();
            $table->foreignId('id_keluarga')->nullable();
            $table->string('status_keluarga')->nullable();
            $table->string('name_ayah')->nullable();
            $table->string('name_ibu')->nullable();
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender',['pria','wanita']);
            $table->enum('blood',['A','B','O','AB']);
            $table->string('address');
            $table->integer('rt');
            $table->integer('rw');
            $table->string('kelurahan_desa');
            $table->string('kecamatan');
            $table->string('religion');
            $table->string('status_perkawinan');
            $table->string('profession');
            $table->string('kewerganegaraan');
            $table->string('education');
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
        Schema::dropIfExists('penduduks');
    }
}
