<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInpresProgramsTable.
 */
class CreateInpresProgramsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_inpres_programs', function(Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->bigInteger('inpres_sasaran_id');
			$table->foreign('inpres_sasaran_id')->references('id')->on('new_inpres_sasarans');
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
		Schema::drop('new_inpres_programs');
	}
}
