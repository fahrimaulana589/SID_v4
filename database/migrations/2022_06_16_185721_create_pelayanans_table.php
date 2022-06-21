<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pelayanans');
        Schema::create('pelayanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nik_penduduks");
            $table->foreignId("id_surat_keluar");
            $table->string("status");
            $table->text("images");
            $table->text("attribute");
            $table->text("keperluan");
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
        Schema::dropIfExists('pelayanans');
    }
}
