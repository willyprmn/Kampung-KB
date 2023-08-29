<?php

use Illuminate\Database\Seeder;
use App\Models\PenggunaanData;

class PenggunaanDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PenggunaanData::insert([
            ['name' => 'PK dan Pemutahiran Data'], 
            ['name' => 'Data Rutin BKKBN'], 
            ['name' => 'Potensi Desa'], 
            ['name' => 'Data Sektoral'], 
            ['name' => 'Lainnya']
        ]);
    }
}
