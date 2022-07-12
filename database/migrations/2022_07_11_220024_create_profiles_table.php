<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->string("sambutan");
            $table->string("description");
            $table->string("logo");
            $table->string("background");
            $table->string("slogan");
            $table->string("kepala_desa");
            $table->string("sambutan_kepala_desa");

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
