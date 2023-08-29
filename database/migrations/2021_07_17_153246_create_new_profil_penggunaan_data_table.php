<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProfilPenggunaanDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_penggunaan_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profil_id');
            $table->foreign('profil_id')->references('id')->on('new_profil_kampung')->onDelete('cascade');
            $table->bigInteger('penggunaan_data_id');
            $table->foreign('penggunaan_data_id')->references('id')->on('new_penggunaan_data');
            $table->unique(['profil_id', 'penggunaan_data_id']);
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
        Schema::dropIfExists('new_profil_penggunaan_data');
    }
}
