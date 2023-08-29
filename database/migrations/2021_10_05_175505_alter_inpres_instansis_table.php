<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInpresInstansisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_inpres_instansis', function (Blueprint $table) {
            $table->dropForeign('new_inpres_instansis_inpres_kegiatan_id_foreign');
            $table->foreign('inpres_kegiatan_id')->references('id')->on('new_inpres_kegiatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
