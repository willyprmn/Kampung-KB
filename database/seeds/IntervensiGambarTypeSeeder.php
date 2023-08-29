<?php

use Illuminate\Database\Seeder;
use App\Models\IntervensiGambarType;

class IntervensiGambarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IntervensiGambarType::insert([
            [
                'name' => 'Kegiatan',
                'jenis_post_id' => 2
            ],
            [
                'name' => 'Sebelum',
                'jenis_post_id' => 1,
            ],
            [
                'name' => 'Sesudah',
                'jenis_post_id' => 1,
            ],
        ]);
    }
}
