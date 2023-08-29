<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresKegiatanKeywordsTable.
 */
class CreateInpresKegiatanKeywordsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_kegiatan_keywords', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('inpres_kegiatan_id');
			$table->foreign('inpres_kegiatan_id')->references('id')->on('new_inpres_kegiatans');
			$table->bigInteger('keyword_id');
			$table->foreign('keyword_id')->references('id')->on('new_keywords');
			$table->unique(['inpres_kegiatan_id', 'keyword_id']);
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
		Schema::drop('new_inpres_kegiatan_keywords');
	}
}
