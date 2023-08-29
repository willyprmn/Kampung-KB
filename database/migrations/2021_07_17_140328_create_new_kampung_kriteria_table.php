<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKampungKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kampung_kriteria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampung_kb_id');
            $table->foreign('kampung_kb_id')->references('id')->on('new_kampung_kb')->onUpdate('cascade');
            $table->bigInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id')->on('new_kriteria');
            $table->boolean('kriteria_flag')->nullable();
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
        Schema::dropIfExists('new_kampung_kriteria');
    }
}
