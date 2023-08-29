<?php

use Illuminate\Database\Seeder;
use App\Models\Instansi;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instansi::insert([
            [
                'name' => 'Dinas Perhubungan',
                'alias' => 'dinas_perhubungan'
            ],
            [
                'name' => 'Dinas Kelautan dan Perikanan',
                'alias' => 'dinas_kelautan'
            ],
            [
                'name' => 'Dinas Pariwisata',
                'alias' => 'dinas_pariwisata'
            ],
            [
                'name' => 'Dinas Energi dan Sumber Daya Mineral',
                'alias' => 'dinas_esdm'
            ],
            [
                'name' => 'Dinas Dukcapil',
                'alias' => 'dinas_dukcapil'
            
            ],
            [
                'name' => 'TNI – POLRI',
                'alias' => 'tni_polri'
            ],
            [
                'name' => 'Kanwil Kementerian Hukum dan HAM',
                'alias' => 'kemenkumham'
            ],
            [
                'name' => 'Dinas Kominfo',
                'alias' => 'dinas_kominfo'
            ],
            [
                'name' => 'BUMN dan BUMD',
                'alias' => 'bumn_bumd'
            ],
            [
                'name' => 'Dinas Koperasi',
                'alias' => 'dinas_koperasi',
            ],
            [
                'name' => 'Dinas Perindustrian',
                'alias' => 'dinas_perindustrian',
            ],
            [
                'name' => 'Dinas Perdagangan',
                'alias' => 'dinas_perdagangan',
            ],
            [
                'name' => 'Dinas Pertanian',
                'alias' => 'dinas_pertanian',
            ],
            [
                'name' => 'Dinas Ketenagakerjaan',
                'alias' => 'dinas_ketenagakerjaan',
            ],
            [
                'name' => 'Dinas Pekerjaan Umum dan Perumahan Rakyat',
                'alias' => 'dinas_pupr',
            ],
            [
                'name' => 'Dinas Kehutanan dan Lingkungan Hidup',
                'alias' => 'dinas_klh',
            ],
            [
                'name' => 'Dinas Bina Marga dan Penataan Ruang',
                'alias' => 'dinas_bmpr',
            ],
            [
                'name' => 'Kanwil Kementrian Agama',
                'alias' => 'kanwil_kemenag',
            ],
            [
                'name' => 'Dinas Kesehatan',
                'alias' => 'dinas_kesehatan',
            ],
            [
                'name' => 'Dinas Sosial',
                'alias' => 'dinas_sosial',
            ],
            [
                'name' => 'Dinas PP dan PA',
                'alias' => 'dinas_pppa',
            ],
            [
                'name' => 'Dinas Pendidikan',
                'alias' => 'dinas_pendidikan',
            ],
            [
                'name' => 'Dinas Pemuda dan Olahraga',
                'alias' => 'dinas_olagraga',
            ],
            [
                'name' => 'Dinas Pemberdayaan dan Masyarakat Desa',
                'alias' => 'dinas_pmds',
            ],
            [
                'name' => 'Pemerintahan Daerah',
                'alias' => 'pemerintah_daerah',
            ],
            [
                'name' => 'OPD Pengendalian Penduduk dan KB',
                'alias' => 'odp_ppkb',
            ],
            [
                'name' => 'Pemerintahan Desa/Lurah',
                'alias' => 'pemerindah_desa',
            ],
            [
                'name' => 'Lembaga Pendidikan',
                'alias' => 'lembaga_pendidikan',
            ],
            [
                'name' => 'Swasta/Perusahaan',
                'alias' => 'swasta',
            ],
            [
                'name' => 'Puskesmas',
                'alias' => 'puskesmas',
            ],
            [
                'name' => 'Rumah Sakit/Klinik',
                'alias' => 'rumah_sakit',
            ],
            [
                'name' => 'Komponen Masyarakat Kampung KB',
                'alias' => 'kmkb',
            ],
            [
                'name' => 'BPS',
                'alias' => 'bps',
            ],
            [
                'name' => 'Perwakilan BKKBN',
                'alias' => 'perwakilan_bkkbn',
            ],
            [
                'name' => 'Dinas Ketahanan Pangan',
                'alias' => 'dinas_ketahanan_pangan',
            ],
            [
                'name' => 'Dinas Peternakan dan Kesehatan Hewan',
                'alias' => 'dinas_dpkh',
            ],
            [
                'name' => 'Lainnya',
                'alias' => 'lainnya',
            ]
        ]);
    }
}
