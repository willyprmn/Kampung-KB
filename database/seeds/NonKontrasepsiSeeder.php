<?php

use Illuminate\Database\Seeder;
use App\Models\NonKontrasepsi;

class NonKontrasepsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NonKontrasepsi::insert([
            #1
            ['name' => 'Karena Hamil', 'alias' => 'hamil'],
            #2
            ['name' => 'Karena Ingin Anak Segera', 'alias' => 'anak_segera'],
            #3
            ['name' => 'Ingin Anak Kemudian/Ingin Anak Tunda (IAT)', 'alias' => 'anak_kemudian'],
            #4
            ['name' => 'Tidak Ingin Anak Lagi', 'alias' => 'tidak_ingin_anak']
        ]);
    }
}
