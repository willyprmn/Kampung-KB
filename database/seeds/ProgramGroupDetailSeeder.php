<?php

use Illuminate\Database\Seeder;
use App\Models\ProgramGroupDetail;

class ProgramGroupDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramGroupDetail::insert([
            [
                'program_group_id' => '1',
                'program_id' => 1,
            ],
            [
                'program_group_id' => '1',
                'program_id' => 2
            ],
            [
                'program_group_id' => '1',
                'program_id' => 3
            ],
            [
                'program_group_id' => '1',
                'program_id' => 4
            ],
            [
                'program_group_id' => '1',
                'program_id' => 5
            ],
            [
                'program_group_id' => '1',
                'program_id' => 6
            ],
            [
                'program_group_id' => '1',
                'program_id' => 7
            ],
            [
                'program_group_id' => '2',
                'program_id' => 1
            ],
            [
                'program_group_id' => '2',
                'program_id' => 2
            ],
            [
                'program_group_id' => '2',
                'program_id' => 3
            ],
            [
                'program_group_id' => '2',
                'program_id' => 4
            ],
            [
                'program_group_id' => '2',
                'program_id' => 5
            ],
            [
                'program_group_id' => '3',
                'program_id' => 1
            ],
            [
                'program_group_id' => '3',
                'program_id' => 2
            ],
            [
                'program_group_id' => '3',
                'program_id' => 3
            ],
            [
                'program_group_id' => '3',
                'program_id' => 4
            ],
            [
                'program_group_id' => '3',
                'program_id' => 5
            ],
            [
                'program_group_id' => '3',
                'program_id' => 8
            ],
            [
                'program_group_id' => '3',
                'program_id' => 9
            ],
            [
                'program_group_id' => '3',
                'program_id' => 10
            ]
        ]);
    }
}
