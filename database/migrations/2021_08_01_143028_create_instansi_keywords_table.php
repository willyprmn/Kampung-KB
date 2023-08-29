<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInstansiKeywordsTable.
 */
class CreateInstansiKeywordsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_instansi_keywords', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('instansi_id');
			$table->foreign('instansi_id')->references('id')->on('new_instansi');
			$table->bigInteger('keyword_id');
			$table->foreign('keyword_id')->references('id')->on('new_keywords');
			$table->unique(['instansi_id', 'keyword_id']);
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
		Schema::drop('new_instansi_keywords');
	}
}
