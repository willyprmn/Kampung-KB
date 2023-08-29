<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoleLevelsTable.
 */
class CreateRoleLevelsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_role_levels', function(Blueprint $table) {
            $table->id();
			$table->foreignId('role_id')->onDelete('cascade');
			$table->integer('child_id')->references('id')->on('new_roles')->onDelete('cascade');
			$table->unique(['role_id', 'child_id']);
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
		Schema::drop('new_role_levels');
	}
}
