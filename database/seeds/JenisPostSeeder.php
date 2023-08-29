<?php

use Illuminate\Database\Seeder;
use App\Models\JenisPost;

class JenisPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisPost::insert([
            ['name' => 'Sebelum - Sesudah'], ['name' => 'Kegiatan']
        ]);
    }
}
