<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConfigurationStatisticsTable.
 */
class CreateConfigurationStatisticsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_configuration_statistics', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->nullable();
			$table->text('title')->nullable();
			$table->text('description')->nullable();
			$table->text('tooltip')->nullable();
			$table->text('route')->nullable();
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
		Schema::drop('new_configuration_statistics');
	}
}
