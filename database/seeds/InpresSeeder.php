<?php

use Illuminate\Database\Seeder;


use App\Models\{
    Inpres,
    InpresSasaran,
    InpresProgram
};

class InpresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::transaction(function () {

            Inpres::truncate();

            $inpres = Inpres::create([
                'name' => 'INTEGRASI DAN KONVERGENSI KEGIATAN OPTIMALISASI PENYELENGGARAAN KAMPUNG KELUARGA BERKUALITAS',
                'subject' => 'OPTIMALISASI PENYELENGGARAAN KAMPUNG KELUARGA BERKUALITAS',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sasaran = new InpresSasaranSeeder($inpres);
            $sasaran->run($inpres);

        // });
    }
}
