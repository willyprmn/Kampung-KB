<?php

use Illuminate\Database\Seeder;
use App\Models\Kontrasepsi;

class KontrasepsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kontrasepsi::insert([
            ['name' => 'IUD'],['name' => 'MOW'],['name' => 'MOP'],['name' => 'Kondom'],['name' => 'Implan'],['name' => 'Suntik'],['name' => 'PIL']
        ]);
    }
}
