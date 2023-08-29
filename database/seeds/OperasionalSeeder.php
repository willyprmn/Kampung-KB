<?php

use Illuminate\Database\Seeder;
use App\Models\Operasional;

class OperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operasional::insert([
            ['name' => 'Rapat perencanaan kegiatan'],
            ['name' => 'Rapat koordinasi dengan dinas/instansi terkait pendukung kegiatan'],
            ['name' => 'Sosialisasi Kegiatan'],
            ['name' => 'Monitoring dan Evaluasi Kegiatan'],
            ['name' => 'Penyusunan Laporan']
        ]);
    }
}
