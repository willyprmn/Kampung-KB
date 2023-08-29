<?php

use Illuminate\Database\Seeder;
use App\Models\Regulasi;

class RegulasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regulasi::insert([
            ['name' => 'Surat Keputusan/Instruksi/Surat Edaran dari Gubernur'],#1
            ['name' => 'Surat Keputusan/Instruksi/Surat Edaran dari Bupati/Walikota'],#2
            ['name' => 'SK Kecamatan tentang Kampung KB'],#3
            ['name' => 'SK Kepala Desa/Lurah tentang Kampung KB']#4
        ]);
    }
}
