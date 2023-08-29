<?php

use Illuminate\Database\Seeder;
use App\Models\Kementerian;

class KementerianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kementerian::truncate();
        Kementerian::insert([
            #1
            [
                'name' => 'Badan Kependudukan dan Keluarga Berencana Nasional'
            ],
            #2
            [
                'name' => 'Kementerian Dalam Negeri'
            ],
            #3
            [
                'name' => 'Kementerian Kesehatan'
            ],
            #4
            [
                'name' => 'Kementerian Agama'
            ],
            #5
            [
                'name' => 'Kementerian Pemberdayaan Perempuan dan Perlindungan Anak'
            ],
            #6
            [
                'name' => 'Kementerian Sosial'
            ],
            #7
            [
                'name' => 'Pemda Kab/Kota'
            ],
            #8
            [
                'name' => 'Kementerian Pendidikan dan Kebudayaan'
            ],
            #9
            [
                'name' => 'Pemerintah Daerah Kabupaten/Kota'
            ],
            #10
            [
                'name' => 'Kementerian Koperasi dan UKM'
            ],
            #11
            [
                'name' => 'Pemerintah Provinsi'
            ],
            #12
            [
                'name' => 'Kementerian Kelautan dan Perikanan'
            ],
            #13
            [
                'name' => 'Pemerintah Daerah'
            ],
            #14
            [
                'name' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat'
            ],
        ]);
    }
}
