<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInpresKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_inpres_kegiatans', function (Blueprint $table) {
            $table->dropForeign('new_inpres_kegiatans_penanggung_jawab_id_foreign');
            $table->foreign('penanggung_jawab_id')->references('id')->on('new_kementerians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_inpres_kegiatans', function (Blueprint $table) {
            $table->dropForeign('new_inpres_kegiatans_penanggung_jawab_id_foreign');
        });
    }
}
