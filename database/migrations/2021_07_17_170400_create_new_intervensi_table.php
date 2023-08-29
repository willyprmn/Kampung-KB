<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewIntervensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_intervensi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inpres_kegiatan_id')->nullable();
            $table->foreign('inpres_kegiatan_id')->references('id')->on('new_inpres_kegiatans');
            $table->bigInteger('kampung_kb_id');
            $table->foreign('kampung_kb_id')->references('id')->on('new_kampung_kb')->onUpdate('cascade');
            $table->bigInteger('jenis_post_id');
            $table->foreign('jenis_post_id')->references('id')->on('new_jenis_post');
            $table->string('judul');
            $table->dateTime('tanggal');
            $table->string('tempat')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->bigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('new_kategori');
            $table->bigInteger('program_id')->nullable();   # From legacy apps, no longer needed
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
        Schema::dropIfExists('new_intervensi');
    }
}
