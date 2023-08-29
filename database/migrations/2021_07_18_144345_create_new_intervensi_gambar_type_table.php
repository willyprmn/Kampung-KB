<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateIntervensiGambarTypeTable.
 */
class CreateNewIntervensiGambarTypeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_intervensi_gambar_type', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name')->unique();
			$table->bigInteger('jenis_post_id');
			$table->foreign('jenis_post_id')->references('id')->on('new_jenis_post');
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
		Schema::drop('new_intervensi_gambar_type');
	}
}
