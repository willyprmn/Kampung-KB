<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIntervensiGambarTable.
 */
class CreateNewIntervensiGambarTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_intervensi_gambar', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('intervensi_id');
			$table->foreign('intervensi_id')->references('id')->on('new_intervensi');
			$table->string('caption')->nullable();
			$table->string('path');
			$table->bigInteger('intervensi_gambar_type_id');
			$table->foreign('intervensi_gambar_type_id')->references('id')->on('new_intervensi_gambar_type');
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
		Schema::drop('new_intervensi_gambar');
	}
}
