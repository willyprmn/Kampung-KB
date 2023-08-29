<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProfilKampungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_profil_kampung', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kampung_kb_id');
            $table->foreign('kampung_kb_id')->references('id')->on('new_kampung_kb')->onUpdate('cascade');
            $table->integer('bulan');
            $table->integer('tahun');

            $table->boolean('pokja_pengurusan_flag')->nullable();
            $table->boolean('pokja_sk_flag')->nullable();
            $table->boolean('pokja_pelatihan_flag')->nullable();
            $table->string('pokja_pelatihan_desc')->nullable();
            $table->integer('pokja_jumlah')->nullable();
            $table->integer('pokja_jumlah_terlatih')->nullable();

            $table->boolean('plkb_pendamping_flag')->nullable();
            $table->string('plkb_nip')->nullable();
            $table->string('plkb_nama')->nullable();
            $table->string('plkb_kontak')->nullable();
            $table->bigInteger('plkb_pengarah_id')->nullable();
            $table->foreign('plkb_pengarah_id')->references('id')->on('new_plkb_pengarah');
            $table->string('plkb_pengarah_lainnya')->nullable();

            $table->boolean('regulasi_flag')->nullable();
            $table->bigInteger('regulasi_id')->nullable();
            $table->foreign('regulasi_id')->references('id')->on('new_regulasi');

            $table->boolean('rencana_kerja_masyarakat_flag')->nullable();
            $table->boolean('penggunaan_data_flag')->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('new_users');

            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('new_profil_kampung');
    }
}
