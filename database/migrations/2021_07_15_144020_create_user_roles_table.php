<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserRolesTable.
 */
class CreateUserRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_user_roles', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('new_users');
			$table->bigInteger('role_id');
			$table->foreign('role_id')->references('id')->on('new_roles');
			$table->unique(['user_id', 'role_id']);
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
		Schema::drop('new_user_roles');
	}
}
