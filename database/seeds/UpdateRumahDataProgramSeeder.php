<?php

use Illuminate\Database\Seeder;

use App\Models\Program;

class UpdateRumahDataProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rumahData = Program::find(7);
        $rumahData->deskripsi = 'Rumah Data Kependudukan Kampung KB';
        $rumahData->save();
    }
}
