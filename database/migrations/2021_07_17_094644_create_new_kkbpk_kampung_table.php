<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewKkbpkKampungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_kkbpk_kampung', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->bigInteger('kampung_kb_id');
            $table->foreign('kampung_kb_id')->references('id')->on('new_kampung_kb')->onUpdate('cascade');
            $table->integer('pengguna_bpjs');
            $table->boolean('is_active')->nullable();
            $table->unique(['kampung_kb_id', 'is_active']);
            $table->bigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('new_users')->onUpdate('cascade');
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
        Schema::dropIfExists('new_kkbpk_kampung');
    }
}
