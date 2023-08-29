<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewKampungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_kampung_kb', function (Blueprint $table) {
            $table->dropUnique('new_kampung_kb_kabupaten_id_contoh_kabupaten_flag_unique');
            $table->dropUnique('new_kampung_kb_provinsi_id_contoh_provinsi_flag_unique');
            $table->unique(['kabupaten_id', 'contoh_kabupaten_flag', 'is_active']);
            $table->unique(['provinsi_id', 'contoh_provinsi_flag', 'is_active']);
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
