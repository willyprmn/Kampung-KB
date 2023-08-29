<?php

use Illuminate\Database\Seeder;
use App\Models\ConfigurationStatistic;

class StatistikUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigurationStatistic::where('id', 17)->update(['route' => 'portal.statistik.fungsi-keluarga']);
    }
}
