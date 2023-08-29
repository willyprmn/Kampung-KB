<?php

use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #disabled old data
        // DB::unprepared(file_get_contents(database_path('sql/seeder/01-wilayah.sql')));

        #use data regional siga
        DB::unprepared(file_get_contents(database_path('sql/seeder/23-siga-regional-replace.sql')));
    }
}
