<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPendudukKampungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_penduduk_kampung', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampung_kb_id');
            $table->foreign('kampung_kb_id')->references('id')->on('new_kampung_kb')->onUpdate('cascade');
            $table->boolean('is_active')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('new_users')->onUpdate('cascade');
            $table->unique(['is_active', 'kampung_kb_id']);
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
        Schema::dropIfExists('new_penduduk_kampung');
    }
}
