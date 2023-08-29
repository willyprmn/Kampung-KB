<?php

use Illuminate\Database\Seeder;
use App\Models\Sasaran;

class SasaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sasaran::insert([
            ['name' => 'Seluruh Penduduk'],
            ['name' => 'PUS'],
            ['name' => 'Remaja'],
            ['name' => 'Lansia'],
            ['name' => 'Balita'],
            ['name' => 'Keluarga yang memiliki Balita'],
            ['name' => 'Keluarga yang memiliki Remaja'],
            ['name' => 'Keluarga yang memiliki Lansia'],
            ['name' => 'Lainnya'],
        ]);
    }
}
