<?php

use Illuminate\Database\Seeder;
use App\Models\Frekuensi;

class FrekuensiOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #mingguan
        Frekuensi::where('id', 1)->update(['order' => 1]);
        #bulanan
        Frekuensi::where('id', 2)->update(['order' => 2]);
        #triwulan
        Frekuensi::where('id', 5)->update(['order' => 3]);
        #semesteran
        Frekuensi::where('id', 4)->update(['order' => 4]);
        #tahunan
        Frekuensi::where('id', 3)->update(['order' => 5]);
        #lainnya
        Frekuensi::where('id', 6)->update(['order' => 6]);
    }
}
