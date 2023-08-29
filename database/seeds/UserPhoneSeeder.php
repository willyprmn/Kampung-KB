<?php

use Illuminate\Database\Seeder;

class UserPhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $sqlPath = 'sql/seeder/24-user-phone.sql';
        $sql = file_get_contents(database_path($sqlPath));
        DB::unprepared($sql);
    }
}
