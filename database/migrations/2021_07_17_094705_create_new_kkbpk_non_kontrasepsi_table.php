<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKkbpkNonKontrasepsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kkbpk_non_kontrasepsi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kkbpk_kampung_id');
            $table->foreign('kkbpk_kampung_id')->references('id')->on('new_kkbpk_kampung');
            $table->bigInteger('non_kontrasepsi_id');
            $table->foreign('non_kontrasepsi_id')->references('id')->on('new_non_kontrasepsi');
            $table->integer('jumlah');
            $table->unique(['kkbpk_kampung_id', 'non_kontrasepsi_id']);
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
        Schema::dropIfExists('new_kkbpk_non_kontrasepsi');
    }
}
