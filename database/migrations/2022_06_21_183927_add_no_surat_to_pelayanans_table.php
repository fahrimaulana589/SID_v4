<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pelayanans', function (Blueprint $table) {
            $table->string("no_surat");
        });
    }

    public function down()
    {
        Schema::table('pelayanans', function (Blueprint $table) {
            $table->dropColumn("no_surat");
        });
    }
};
