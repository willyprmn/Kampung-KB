<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoleMenusTable.
 */
class CreateRoleMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_role_menus', function(Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('role_id');
			$table->foreign('role_id')->references('id')->on('new_roles');
			$table->bigInteger('menu_id');
			$table->foreign('menu_id')->references('id')->on('new_menus');
			$table->unique(['role_id', 'menu_id']);
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
		Schema::drop('new_role_menus');
	}
}
