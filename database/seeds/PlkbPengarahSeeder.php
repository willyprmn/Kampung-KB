<?php

use Illuminate\Database\Seeder;
use App\Models\PlkbPengarah;

class PlkbPengarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlkbPengarah::insert([
            ['name' => 'Kader'],['name' => 'Ketua RT/RW'],
            ['name' => 'Perangkat Desa/Kelurahan'],
            ['name' => 'PKK'],
            ['name' => 'Toga/ Toma'],
            ['name' => 'OPDKB Kab/kota'], 
            ['name' => 'Perwakilan BKKBN Prov'], 
            ['name' => 'PLKB Non PNS'], 
            ['name' => 'Lainnya']
        ]);
    }
}
