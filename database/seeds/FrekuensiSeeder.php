<?php

use Illuminate\Database\Seeder;
use App\Models\Frekuensi;

class FrekuensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Frekuensi::insert([
            ['name' => 'Mingguan'],['name' => 'Bulanan'],['name' => 'Tahunan'],
            ['name' => 'Semesteran'],
            ['name' => 'Triwulan'],
            ['name' => 'Lainnya']
        ]);
    }
}
