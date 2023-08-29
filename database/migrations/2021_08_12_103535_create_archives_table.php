<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateArchivesTable.
 */
class CreateArchivesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_archives', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('path');
			$table->string('ext');
			$table->morphs('attachable');
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
		Schema::drop('new_archives');
	}
}
