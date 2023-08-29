<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateNewUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_users', function(Blueprint $table) {
            $table->increments('id');
			$table->string('email')->unique(); 	# Only for devel
			$table->string('password');			# Only for devel
			$table->string('siga_id')->unique();
			$table->char('provinsi_id', 2)->nullable();
			$table->foreign('provinsi_id')->references('id')->on('new_provinsi');
			$table->char('kabupaten_id', 4)->nullable();
			$table->foreign('kabupaten_id')->references('id')->on('new_kabupaten');
			$table->char('kecamatan_id', 6)->nullable();
			$table->foreign('kecamatan_id')->references('id')->on('new_kecamatan');
			$table->char('desa_id', 10)->nullable();
			$table->boolean('is_active')->nullable()->default(true);
			// $table->foreign('desa_id')->references('id')->on('new_desa'); #remove fk to handle old id
			$table->rememberToken();
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
		Schema::drop('new_users');
	}
}
