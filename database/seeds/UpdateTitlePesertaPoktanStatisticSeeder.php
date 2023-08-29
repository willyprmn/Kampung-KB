<?php

use Illuminate\Database\Seeder;
use App\Models\ConfigurationStatistic;

class UpdateTitlePesertaPoktanStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stat = ConfigurationStatistic::find(20);
        $stat->description = 'Jumlah Sasaran Program Ketahanan Keluarga yang Mengikuti Kegiatan Poktan';
        $stat->save();
    }
}
