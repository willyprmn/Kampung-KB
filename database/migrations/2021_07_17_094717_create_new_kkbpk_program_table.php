<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKkbpkProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kkbpk_program', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kkbpk_kampung_id');
            $table->foreign('kkbpk_kampung_id')->references('id')->on('new_kkbpk_kampung');
            $table->bigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('new_program');
            $table->integer('jumlah');
            $table->unique(['kkbpk_kampung_id', 'program_id']);
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
        Schema::dropIfExists('new_kkbpk_program');
    }
}
