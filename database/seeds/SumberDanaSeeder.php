<?php

use Illuminate\Database\Seeder;
use App\Models\SumberDana;

class SumberDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SumberDana::insert([
            ['name' => 'APBN'], #1
            ['name' => 'APBD'], #2
            ['name' => 'Dana Desa'], #3
            ['name' => 'Donasi/ Hibah Masyarakat'], #6
            ['name' => 'Perusahaan (CSR)'], #5
            ['name' => 'Swadaya Masyarakat'], #4
        ]);
    }
}
