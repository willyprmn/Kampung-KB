<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKampungKbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kampung_kb', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('penanggungjawab_id');
            $table->date('tanggal_pencanangan');
            $table->string('cakupan_wilayah')->nullable();
            $table->char('provinsi_id', 2)->nullable();
            $table->foreign('provinsi_id')->references('id')->on('new_provinsi');
            $table->char('kabupaten_id', 4)->nullable();
            $table->foreign('kabupaten_id')->references('id')->on('new_kabupaten');
            $table->char('kecamatan_id', 6)->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('new_kecamatan');
            $table->char('desa_id', 10)->nullable();
            $table->foreign('desa_id')->references('id')->on('new_desa');
            $table->string('rw')->nullable();
            $table->longText('gambaran_umum')->nullable();
            $table->string('path_gambar')->nullable();
            $table->string('path_struktur')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('contoh_kabupaten_flag')->nullable();
            $table->boolean('contoh_provinsi_flag')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('new_users')->onUpdate('cascade');
            $table->bigInteger('updated_by')->nullable();
            $table->unique(['kabupaten_id', 'contoh_kabupaten_flag']);
            $table->unique(['provinsi_id', 'contoh_provinsi_flag']);
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

        Schema::dropIfExists('new_kampung_kb');
    }
}
