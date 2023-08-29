<?php

use Illuminate\Database\Seeder;
use App\Models\Intervensi;

class IntervensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path('sql/seeder/09-intervensi.sql')));
        $max = Intervensi::max('id') + 1;
        DB::unprepared("ALTER SEQUENCE new_intervensi_id_seq RESTART WITH {$max}");
    }
}
