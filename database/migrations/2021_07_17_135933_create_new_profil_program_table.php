<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProfilProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_program', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profil_id');
            $table->foreign('profil_id')->references('id')->on('new_profil_kampung')->onDelete('cascade');
            $table->boolean('program_flag')->nullable();
            $table->bigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('new_program');
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
        Schema::dropIfExists('new_profil_program');
    }
}
