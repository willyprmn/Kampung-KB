<?php

use Illuminate\Database\Seeder;

class KkbpkProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path('sql/seeder/13-kkbpk-program.sql')));
    }
}
