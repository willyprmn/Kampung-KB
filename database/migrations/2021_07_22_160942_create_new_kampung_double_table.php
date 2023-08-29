<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKampungDoubleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kampung_double', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampung_id')->nullable()->default(12);
            $table->bigInteger('kampung_id_double')->nullable()->default(12);
            $table->text('merger_proses')->nullable();
            $table->text('merger_kriteria')->nullable();
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
        Schema::dropIfExists('new_kampung_double');
    }
}
