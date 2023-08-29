<?php

use Illuminate\Database\Seeder;

use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::insert([
            # 1
            [
                'name' => 'BKB',
                'deskripsi' => 'Bina Keluarga Balita (BKB)',
            ],

            # 2
            [
                'name' => 'BKR',
                'deskripsi' => 'Bina Keluarga Remaja (BKR)'
            ],

            # 3
            [
                'name' => 'BKL',
                'deskripsi' => 'Bina Keluarga Lansia (BKL)'
            ],

            # 4
            [
                'name' => 'UPPKA',
                'deskripsi' => 'Usaha Peningkatan Pendapatan Keluarga Akseptor (UPPKA)'
            ],

            # 5
            [
                'name' => 'PIK R',
                'deskripsi' => 'Pusat Informasi dan Konseling Remaja (PIK R)'
            ],

            # 6
            [
                'name' => 'Sekretariat KKB',
                'deskripsi' => 'Sekretariat Kampung KB'
            ],

            # 7
            [
                'name' => 'Rumah Dataku',
                'deskripsi' => 'Rumah Dataku'
            ],

            # 8
            [
                'name' => 'Pelayanan KB-KR',
                'deskripsi' => 'Pelayanan KB-KR'
            ],

            # 9
            [
                'name' => 'Kependudukan',
                'deskripsi' => 'Kependudukan'
            ],

            # 10
            [
                'name' => 'Sektor Lain',
                'deskripsi' => 'Sektor Lain'
            ]
        ]);
    }
}
