<?php

use Illuminate\Database\Seeder;
use App\Models\Keluarga;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Keluarga::insert([
            [
                'name' => 'Pasangan Usia Subur',
                'alias' => 'pus',
            ],
            [
                'name' => 'Jumlah Keluarga',
                'alias' => 'keluarga',
            ],
            [
                'name' => 'Jumlah Remaja',
                'alias' => 'remaja',
            ],
            [
                'name' => 'Keluarga yang Memiliki Balita',
                'alias' => 'memiliki_balita',
            ],
            [
                'name' => 'Keluarga yang Memiliki Remaja',
                'alias' => 'memiliki_remaja',
            ],
            [
                'name' => 'Keluarga yang Memiliki Lansia',
                'alias' => 'memiliki_lansia',
            ]
        ]);
    }
}
