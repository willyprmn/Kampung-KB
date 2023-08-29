<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewIntervensiInstansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_intervensi_instansi', function (Blueprint $table) {
            $table->dropForeign('new_intervensi_instansi_intervensi_id_foreign');
            $table->foreign('intervensi_id')->references('id')->on('new_intervensi')->onDelete('cascade');
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
