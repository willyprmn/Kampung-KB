<?php

use Illuminate\Database\Seeder;
use App\Models\IntervensiGambar;
class IntervensiGambarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::disableQueryLog();

        // DB::transaction(function () {
            DB::unprepared(file_get_contents(database_path('sql/seeder/19-intervensi-gambar.sql')));
        // });
    }
}
