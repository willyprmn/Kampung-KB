<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresTargetsTable.
 */
class CreateInpresTargetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_targets', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('inpres_kegiatan_id');
			$table->foreign('inpres_kegiatan_id')->references('id')->on('new_inpres_kegiatans')->onDelete('cascade');
			$table->string('name');
			$table->string('value');
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
		Schema::drop('new_inpres_targets');
	}
}
