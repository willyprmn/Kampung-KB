<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresSasaransTable.
 */
class CreateInpresSasaransTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_sasarans', function(Blueprint $table) {
            $table->id();
			$table->bigInteger('inpres_id');
			$table->foreign('inpres_id')->references('id')->on('new_inpres');
			$table->string('name');
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
		Schema::drop('new_inpres_sasarans');
	}
}
