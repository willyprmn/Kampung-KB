<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProfilSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_sumber_dana', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profil_id');
            $table->foreign('profil_id')->references('id')->on('new_profil_kampung')->onDelete('cascade');
            $table->bigInteger('sumber_dana_id')->references('id')->on('new_sumber_dana');
            $table->unique(['profil_id', 'sumber_dana_id']);
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
        Schema::dropIfExists('new_profil_sumber_dana');
    }
}
