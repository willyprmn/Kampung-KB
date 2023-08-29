<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresKegiatansTable.
 */
class CreateInpresKegiatansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_kegiatans', function(Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('indikator');
			$table->bigInteger('penanggung_jawab_id');
			$table->foreign('penanggung_jawab_id')->references('id')->on('new_instansi');
			$table->bigInteger('inpres_program_id');
			$table->foreign('inpres_program_id')->references('id')->on('new_inpres_programs');
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
		Schema::drop('new_inpres_kegiatans');
	}
}
