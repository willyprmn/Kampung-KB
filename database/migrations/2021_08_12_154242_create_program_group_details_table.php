<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProgramGroupDetailsTable.
 */
class CreateProgramGroupDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_program_group_details', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('program_group_id');
            $table->foreign('program_group_id')->references('id')->on('new_program_group');
            $table->bigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('new_program');
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
		Schema::drop('new_program_group_details');
	}
}
