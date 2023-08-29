<?php

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kriteria::insert([
            ['name' => 'Kriteria 1', 'description' => 'Peserta KB lebih rendah dari rata rata desa'],
            ['name' => 'Kriteria 2', 'description' => 'Jumlah penduduk miskin tinggi (prasejahtera dan KS 1 lebih tinggi dari rata rata desa'],
            ['name' => 'Kriteria 3', 'description' => 'Termasuk wilayah terpencil, perbatasan, dsb'],
            ['name' => 'Lainnya', 'description' => 'Lainnya']
        ]);
    }
}
