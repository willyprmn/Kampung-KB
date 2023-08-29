<?php

use Illuminate\Database\Seeder;
use App\Models\Kampung;

class KampungCleansingUnmetNeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(base_path('database/sql/seeder/25-cleansing-pus.sql'));
        DB::unprepared($sql);
    }
}
