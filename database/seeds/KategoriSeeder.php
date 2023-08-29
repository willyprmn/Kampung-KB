<?php

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::insert([
            ['name' => 'Keagamaan', 'deskripsi' =>'Seksi Keagamaan'],
            ['name' => 'Pendidikan', 'deskripsi' =>'Seksi Pendidikan'],
            ['name' => 'Reproduksi', 'deskripsi' =>'Seksi Reproduksi'],
            ['name' => 'Ekonomi', 'deskripsi' =>'Seksi Ekonomi'],
            ['name' => 'Perlindungan', 'deskripsi' =>'Seksi Perlindungan'],
            ['name' => 'Kasih Sayang', 'deskripsi' =>'Seksi Kasih Sayang'],
            ['name' => 'Sosial Budaya', 'deskripsi' =>'Seksi Sosial Budaya'],
            ['name' => 'Pembinaan Lingkungan', 'deskripsi' =>'Seksi Pembinaan Lingkungan'],
            ['name' => 'Lainnya', 'description' => ''],
        ]);
    }
}
