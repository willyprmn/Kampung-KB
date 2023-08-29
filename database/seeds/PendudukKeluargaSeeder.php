<?php

use Illuminate\Database\Seeder;

class PendudukKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path('sql/seeder/18-penduduk-keluarga.sql')));
    }
}
