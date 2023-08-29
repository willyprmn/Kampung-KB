<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPendudukKeluargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_penduduk_keluarga', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penduduk_kampung_id');
            $table->foreign('penduduk_kampung_id')->references('id')->on('new_penduduk_kampung');
            $table->bigInteger('keluarga_id');
            $table->foreign('keluarga_id')->references('id')->on('new_keluarga');
            $table->integer('jumlah');
            $table->unique(['penduduk_kampung_id', 'keluarga_id']);
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

        Schema::dropIfExists("new_kampung_kriteria");

        Schema::dropIfExists("new_intervensi_sasaran");
        Schema::dropIfExists("new_intervensi_instansi");

        Schema::dropIfExists("new_profil_program");
        Schema::dropIfExists("new_profil_sumber_dana");
        Schema::dropIfExists("new_profil_operasional");
        Schema::dropIfExists("new_profil_penggunaan_data");

        Schema::dropIfExists("new_kkbpk_program");
        Schema::dropIfExists("new_kkbpk_kontrasepsi");
        Schema::dropIfExists("new_kkbpk_non_kontrasepsi");

        Schema::dropIfExists("new_kkbpk_kampung");
        Schema::dropIfExists("new_intervensi");
        Schema::dropIfExists("new_profil_kampung");
        Schema::dropIfExists('new_penduduk_keluarga');
    }
}
