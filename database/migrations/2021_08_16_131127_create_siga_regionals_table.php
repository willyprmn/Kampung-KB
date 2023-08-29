<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSigaRegionalsTable.
 */
class CreateSigaRegionalsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('new_siga_regionals', function(Blueprint $table) {
            $table->increments('id');
			$table->char('kodedepdagri_prov', 2);
			$table->text('nama_provinsi');
			$table->char('kodedepdagri_kabupaten', 2);
			$table->text('nama_kabupaten');
			$table->char('kodedepdagri_kecamatan', 2);
			$table->text('nama_kecamatan');
			$table->char('kodedepdagri_kelurahan', 4);
			$table->text('nama_kelurahan');
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
		Schema::drop('new_siga_regionals');
	}
}
