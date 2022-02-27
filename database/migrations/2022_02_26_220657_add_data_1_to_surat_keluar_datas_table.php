<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddData1ToSuratKeluarDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_keluar_data', function (Blueprint $table) {
            $table->string('no_surat');
            $table->foreignId('id_penduduk');
            $table->date('tanggal_surat')->nullable();
            $table->string('atas_nama');
            $table->string('jabatan_atas_nama');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_keluar_datas', function (Blueprint $table) {
            //
        });
    }
}
