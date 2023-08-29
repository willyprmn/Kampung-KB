<?php

use Illuminate\Database\Seeder;

class ProfilPenggunaanDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path('sql/seeder/08-profil-penggunaan-data.sql')));
    }
}
