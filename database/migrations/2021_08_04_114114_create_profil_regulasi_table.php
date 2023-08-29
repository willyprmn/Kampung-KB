<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilRegulasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_regulasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profil_id');
            $table->foreign('profil_id')->references('id')->on('new_profil_kampung')->onDelete('cascade');
            $table->bigInteger('regulasi_id');
            $table->foreign('regulasi_id')->references('id')->on('new_regulasi');
            $table->unique(['profil_id', 'regulasi_id']);
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
        Schema::dropIfExists('new_profil_regulasi');
    }
}
