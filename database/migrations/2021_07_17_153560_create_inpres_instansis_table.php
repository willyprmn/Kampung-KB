<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresInstansisTable.
 */
class CreateInpresInstansisTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_instansis', function(Blueprint $table) {
            $table->id();
			$table->bigInteger('inpres_kegiatan_id');
			$table->foreign('inpres_kegiatan_id')->references('id')->on('new_inpres_kegiatans');
			$table->bigInteger('instansi_id');
			$table->foreign('instansi_id')->references('id')->on('new_instansi');
			$table->unique(['inpres_kegiatan_id', 'instansi_id']);
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
		Schema::drop('new_inpres_instansis');
	}
}
