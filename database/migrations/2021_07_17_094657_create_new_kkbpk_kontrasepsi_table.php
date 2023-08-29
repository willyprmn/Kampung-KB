<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKkbpkKontrasepsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kkbpk_kontrasepsi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kkbpk_kampung_id');
            $table->foreign('kkbpk_kampung_id')->references('id')->on('new_kkbpk_kampung');
            $table->bigInteger('kontrasepsi_id');
            $table->foreign('kontrasepsi_id')->references('id')->on('new_kontrasepsi');
            $table->integer('jumlah');
            $table->unique(['kkbpk_kampung_id', 'kontrasepsi_id']);
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
        Schema::dropIfExists('new_kkbpk_kontrasepsi');
    }
}
