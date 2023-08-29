<?php

use Illuminate\Database\Seeder;
use App\Models\Kampung;

class KampungCleansingPendudukKkbpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #run twice, because sometime its not updated all for first iteration
        $sql = file_get_contents(base_path('database/sql/seeder/26-cleansing-penduduk-kkbpk.sql'));
        DB::unprepared($sql);

        $sql = file_get_contents(base_path('database/sql/seeder/26-cleansing-penduduk-kkbpk.sql'));
        DB::unprepared($sql);
    }
}
