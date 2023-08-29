<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProfilOperasionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_operasional', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profil_id');
            $table->foreign('profil_id')->references('id')->on('new_profil_kampung')->onDelete('cascade');
            $table->bigInteger('operasional_id');
            $table->foreign('operasional_id')->references('id')->on('new_operasional');
            $table->boolean('operasional_flag')->nullable();
            $table->bigInteger('frekuensi_id')->nullable();
            $table->foreign('frekuensi_id')->references('id')->on('new_frekuensi');
            $table->string('frekuensi_lainnya')->nullable();
            $table->unique(['operasional_id', 'profil_id']);
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
        Schema::dropIfExists('new_profil_operasional');
    }
}
