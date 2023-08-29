<?php

use Illuminate\Database\Seeder;
use App\Models\Range;

class RangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Range::insert([
            ['range_start' => 0, 'range_end' => 4, 'name' => '0 - 4 Tahun'],
            ['range_start' => 5, 'range_end' => 9, 'name' => '5 - 9 Tahun'],
            ['range_start' => 10, 'range_end' => 14, 'name' => '10 - 14 Tahun'],
            ['range_start' => 15, 'range_end' => 19, 'name' => '15 - 19 Tahun'],
            ['range_start' => 20, 'range_end' => 24, 'name' => '20 - 24 Tahun'],
            ['range_start' => 25, 'range_end' => 29, 'name' => '25 - 29 Tahun'],
            ['range_start' => 30, 'range_end' => 34, 'name' => '30 - 34 Tahun'],
            ['range_start' => 35, 'range_end' => 39, 'name' => '35 - 39 Tahun'],
            ['range_start' => 40, 'range_end' => 44, 'name' => '40 - 44 Tahun'],
            ['range_start' => 45, 'range_end' => 49, 'name' => '45 - 49 Tahun'],
            ['range_start' => 50, 'range_end' => 54, 'name' => '50 - 54 Tahun'],
            ['range_start' => 55, 'range_end' => 59, 'name' => '55 - 59 Tahun'],
            ['range_start' => 60, 'range_end' => 64, 'name' => '60 - 64 Tahun'],
            ['range_start' => 65, 'range_end' => 69, 'name' => '65 - 69 Tahun'],
            ['range_start' => 70, 'range_end' => 74, 'name' => '70 - 74 Tahun'],
            ['range_start' => 75, 'range_end' => 999999, 'name' => '75+ Tahun'],
        ]);
    }
}
