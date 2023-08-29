<?php

use Illuminate\Database\Seeder;
use App\Models\ProgramGroup;

class ProgramGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramGroup::insert([
            #1
            [
                'name' => 'Poktan',
            ],
            #2
            [
                'name' => 'KKBPK',
            ],
            #3
            [
                'name' => 'Intervensi',
            ],
        ]);
    }
}
