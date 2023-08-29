<?php

use Illuminate\Database\Seeder;
use App\Models\{
    Intervensi,
    InpresKegiatan,
};

class IntervensiInpressDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intervensis = Intervensi::pluck('id');
        foreach($intervensis as $item){
            $randomKegiatanId = rand(1, 58);
            //update intervensi
            $intervensi = Intervensi::find($item);
            $intervensi->inpres_kegiatan_id = $randomKegiatanId;
            $intervensi->save();
        }
    }
}
