<?php

use Illuminate\Database\Seeder;
use App\Models\InpresTarget;

class InpresTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InpresTarget::insert([
            [
                'name' => '',
                'value' => '',
            ]
        ]);
    }
}
