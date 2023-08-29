<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewIntervensiInstansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_intervensi_instansi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('intervensi_id');
            $table->foreign('intervensi_id')->references('id')->on('new_intervensi');
            $table->bigInteger('instansi_id')->nullable();
            $table->foreign('instansi_id')->references('id')->on('new_instansi');
            $table->string('instansi_lainnya')->nullable();
            $table->unique(['intervensi_id', 'instansi_id', 'instansi_lainnya']);
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
        Schema::dropIfExists('new_intervensi_instansi');
    }
}
