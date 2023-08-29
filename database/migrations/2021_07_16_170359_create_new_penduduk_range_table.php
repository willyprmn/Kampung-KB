<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPendudukRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_penduduk_range', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penduduk_kampung_id');
            $table->foreign('penduduk_kampung_id')->references('id')->on('new_penduduk_kampung');
            $table->bigInteger('range_id');
            $table->foreign('range_id')->references('id')->on('new_range');
            $table->integer('jumlah');
            $table->char('jenis_kelamin', 1);
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
        Schema::dropIfExists('new_penduduk_range');
    }
}
