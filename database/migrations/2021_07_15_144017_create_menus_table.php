<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMenusTable.
 */
class CreateMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_menus', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name')->nullable();
			$table->string('icon')->nullabl();
			$table->string('label');
			$table->float('order')->unique();
			$table->string('policy_of')->nullable();
			$table->boolean('is_menu');
			$table->bigInteger('parent_id')->nullable();
			$table->foreign('parent_id')->references('id')->on('new_menus');
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
		Schema::drop('new_menus');
	}
}
