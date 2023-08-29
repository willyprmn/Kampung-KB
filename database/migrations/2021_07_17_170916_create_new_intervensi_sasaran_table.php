<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewIntervensiSasaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_intervensi_sasaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('intervensi_id');
            $table->foreign('intervensi_id')->references('id')->on('new_intervensi');
            $table->bigInteger('sasaran_id')->nullable();
            $table->foreign('sasaran_id')->references('id')->on('new_sasaran');
            $table->string('sasaran_lainnya')->nullable();
            $table->unique(['intervensi_id', 'sasaran_id', 'sasaran_lainnya']);
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
        Schema::dropIfExists('new_intervensi_sasaran');
    }
}
