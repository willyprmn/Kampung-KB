<?php

use Illuminate\Database\Seeder;
use App\Models\ConfigurationStatistic;

class ConfigurationStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigurationStatistic::truncate();
        ConfigurationStatistic::insert(
            [
            #profil
            #1
            [
                'parent_id' => null,
                'title' => 'Profil Kampung KB',
                'description' => 'Rekapitulasi Profil Kampung KB',
                'tooltip' => 'Rekapitulasi Profil Kampung KB',
                'route' => null,
            ],
                #2
                [
                    'parent_id' => 1,
                    'title' => 'Tahun Pembentukan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Tahun Pembentukan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Tahun Pembentukan',
                    'route' => "portal.statistik.tahun-pembentukan",
                ],
                #3
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan Sekretariat',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Sekretariat',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Sekretariat',
                    'route' => "portal.statistik.kepemilikan-sekretariat",
                ],
                #4
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan Pokja',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Pokja',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Pokja',
                    'route' => "portal.statistik.kepemilikan-pokja",
                ],
                #5
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan SK Pokja',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan SK Pokja',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan SK Pokja',
                    'route' => "portal.statistik.kepemilikan-sk-pokja",
                ],
                #6
                [
                    'parent_id' => 1,
                    'title' => 'Sumber Dana',
                    'description' => 'Jumlah Kampung KB Berdasarkan Sumber Dana',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Sumber Dana',
                    'route' => "portal.statistik.sumber-dana",
                ],
                #7
                [
                    'parent_id' => 1,
                    'title' => 'Regulasi',
                    'description' => 'Jumlah Kampung KB Berdasarkan Regulasi',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Regulasi',
                    'route' => "portal.statistik.kepemilikan-regulasi",
                ],
                #8
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan Poktan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Poktan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Poktan',
                    'route' => "portal.statistik.kepemilikan-poktan",
                ],
                #9
                [
                    'parent_id' => 1,
                    'title' => 'Kampung KB dengan Pokja Terlatih',
                    'description' => 'Jumlah Kampung KB Berdasarkan Pokja Terlatih',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Pokja Terlatih',
                    'route' => "portal.statistik.pokja-kampung-kb-terlatih",
                ],
                #10
                [
                    'parent_id' => 1,
                    'title' => 'Jumlah Anggota Pokja Terlatih',
                    'description' => 'Jumlah Kampung KB Berdasarkan Jumlah Anggota Pokja Terlatih',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Jumlah Anggota Pokja Terlatih',
                    'route' => 'portal.statistik.pokja-anggota-terlatih',
                ],
                #11
                [
                    'parent_id' => 1,
                    'title' => 'Penggunaan Data Dalam Perencanaan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Penggunaan Data Dalam Perencanaan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Penggunaan Data Dalam Perencanaan',
                    'route' => "portal.statistik.penggunaan-data",
                ],
                #12
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan Rumah Dataku',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Rumah Dataku',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Rumah Dataku',
                    'route' => "portal.statistik.kepemilikan-rumah-dataku",
                ],
                #13
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan PKB/PLKB sebagai Pendamping',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan PKB/PLKB sebagai Pendamping',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan PKB/PLKB sebagai Pendamping',
                    'route' => "portal.statistik.kepemilikan-plkb-pendamping",
                ],
                #14
                [
                    'parent_id' => 1,
                    'title' => 'Mekanisme Operasional',
                    'description' => 'Jumlah Kampung KB Berdasarkan Mekanisme Operasional',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Mekanisme Operasional',
                    'route' => "portal.statistik.mekanisme-operasional",
                ],
            #intervensi
            #15
            [
                'parent_id' => null,
                'title' => 'Intervensi',
                'description' => 'Rekaiputasi Intervensi Kampung KB',
                'tooltip' => 'Rekaiputasi Intervensi Kampung KB',
                'route' => null,
            ],
                #16
                [
                    'parent_id' => 15,
                    'title' => 'Jumlah Kampung KB Menurut Lintas Sektor yang Terlibat Kegiatan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Jumlah Kampung KB Menurut Lintas Sektor yang Terlibat Kegiatan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Jumlah Kampung KB Menurut Lintas Sektor yang Terlibat Kegiatan',
                    'route' => "portal.statistik.intervensi-lintas-instansi",
                ],
                #17
                [
                    'parent_id' => 15,
                    'title' => 'Kegiatan Kampung KB menurut penguatan 8 fungsi keluarga dan lintas sektor yang terlibat',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kegiatan Kampung KB menurut penguatan 8 fungsi keluarga dan lintas sektor yang terlibat',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kegiatan Kampung KB menurut penguatan 8 fungsi keluarga dan lintas sektor yang terlibat',
                    'route' => "portal.statistik.fungsi-keluarga",
                ],
                #18
                [
                    'parent_id' => 15,
                    'title' => 'Kegiatan Kampung KB menurut kategori program dan sasaran kegiatan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kegiatan Kampung KB menurut kategori program dan sasaran kegiatan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kegiatan Kampung KB menurut kategori program dan sasaran kegiatan',
                    'route' => 'portal.statistik.inpres-data-administrasi',
                ],
            #kkbpk
            #19
            [
                'parent_id' => null,
                'title' => 'Perkembangan Program Bangga Kencana',
                'description' => 'Rekaiputasi Perkembangan Program Bangga Kencana Kampung KB',
                'tooltip' => 'Rekaiputasi Perkembangan Program Bangga Kencana Kampung KB',
                'route' => null,
            ],
                #20
                [
                    'parent_id' => 19,
                    'title' => 'Jumlah Peserta Poktan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Jumlah Peserta Poktan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Jumlah Peserta Poktan',
                    'route' => "portal.statistik.kkbpk-jumlah-peserta-poktan",
                ],
                #21
                [
                    'parent_id' => 19,
                    'title' => 'Angka Partisipasi Kegiatan Poktan',
                    'description' => 'Angka Partisipasi Kegiatan Poktan',
                    'tooltip' => 'Angka Partisipasi Kegiatan Poktan',
                    'route' => "portal.statistik.kkbpk-angka-partisipasi-kegiatan-poktan",
                ],
                #22
                [
                    'parent_id' => 19,
                    'title' => 'Jumlah peserta KB per Mix Kontrasepsi',
                    'description' => 'Jumlah Kampung KB Berdasarkan Jumlah peserta KB per Mix Kontrasepsi',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Jumlah peserta KB per Mix Kontrasepsi',
                    'route' => "portal.statistik.kkbpk-peserta-mix-kontrasepsi",
                ],
                #23
                [
                    'parent_id' => 19,
                    'title' => 'Jumlah PUS yang tidak Pakai KB',
                    'description' => 'Jumlah Kampung KB Berdasarkan Jumlah PUS yang tidak Pakai KB',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Jumlah PUS yang tidak Pakai KB',
                    'route' => "portal.statistik.pus-tidak-pakai-kb",
                ],

            
                #child 18
                #24
                [
                    'parent_id' => 18,
                    'title' => 'Penyediaan data dan administrasi kependudukan',
                    'description' => 'Jumlah Kampung KB Berdasarkan Penyediaan data dan peningkatan cakupan pemenuhan administrasi kependudukan',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Penyediaan data dan peningkatan cakupan pemenuhan administrasi kependudukan',
                    'route' => 'portal.statistik.inpres-data-administrasi',
                ],

                #25
                [
                    'parent_id' => 18,
                    'title' => 'Gerakan Masyarakat Hidup Sehat (GERMAS)',
                    'description' => 'Jumlah Kampung KB Berdasarkan Penguatan advokasi dalam Gerakan Masyarakat Hidup Sehat (GERMAS) dan komunikasi perubahan perilaku masyarakat',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Penguatan advokasi dalam Gerakan Masyarakat Hidup Sehat (GERMAS) dan komunikasi perubahan perilaku masyarakat',
                    'route' => 'portal.statistik.inpres-germas-komunikasi',
                ],

                #26
                [
                    'parent_id' => 18,
                    'title' => 'Peningkatan akses Keluarga Berencana dan PKBM dan UKBM',
                    'description' => 'Jumlah Kampung KB Berdasarkan Peningkatan akses dan pelayanan kesehatan termasuk Keluarga Berencana dan Kesehatan Reproduksi melalui program kesehatan berbasis masyarakat (PKBM)/unit-unit pelayanan dan Upaya Kesehatan Bersumberdaya Masyarakat (UKBM)',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Peningkatan akses dan pelayanan kesehatan termasuk Keluarga Berencana dan Kesehatan Reproduksi melalui program kesehatan berbasis masyarakat (PKBM)/unit-unit pelayanan dan Upaya Kesehatan Bersumberdaya Masyarakat (UKBM)',
                    'route' => 'portal.statistik.inpres-pkbm-ukbm',
                ],

                #27
                [
                    'parent_id' => 18,
                    'title' => 'Pendampingan resiko kejadian stunting',
                    'description' => 'Pendampingan dan pelayanan pada keluarga dengan resiko kejadian stunting',
                    'tooltip' => 'Pendampingan dan pelayanan pada keluarga dengan resiko kejadian stunting',
                    'route' => 'portal.statistik.inpres-pendampingan-pelayanan',
                ],
                #28
                [
                    'parent_id' => 18,
                    'title' => 'Peningkatan akses pendidikan',
                    'description' => 'Peningkatan cakupan dan akses pendidikan',
                    'tooltip' => 'Peningkatan cakupan dan akses pendidikan',
                    'route' => 'portal.statistik.inpres-peningkatan-cakupan',
                ],
                #29
                [
                    'parent_id' => 18,
                    'title' => 'Peningkatan cakupan layanan jaminan',
                    'description' => 'Peningkatan cakupan layanan jaminan dan perlindungan sosial pada keluarga dan masyarakat miskin serta rentan',
                    'tooltip' => 'Peningkatan cakupan layanan jaminan dan perlindungan sosial pada keluarga dan masyarakat miskin serta rentan',
                    'route' => 'portal.statistik.inpres-peningkatan-cakupan-layanan',
                ],
                #30
                [
                    'parent_id' => 18,
                    'title' => 'Pemberdayaan ekonomi keluarga',
                    'description' => 'Pemberdayaan ekonomi keluarga',
                    'tooltip' => 'Pemberdayaan ekonomi keluarga',
                    'route' => 'portal.statistik.inpres-pemberdayaan-ekonomi-keluarga',
                ],
                #31
                [
                    'parent_id' => 18,
                    'title' => 'Penataan lingkungan keluarga',
                    'description' => 'Penataan lingkungan keluarga, peningkatan akses air minum, serta sanitasi dasar',
                    'tooltip' => 'Penataan lingkungan keluarga, peningkatan akses air minum, serta sanitasi dasar',
                    'route' => 'portal.statistik.inpres-penataan-lingkungan-keluarga',
                ],

                #32 klasikasi
                [
                    'parent_id' => null,
                    'title' => 'Klasifikasi',
                    'description' => 'Klasifikasi Kampung KB',
                    'tooltip' => 'Klasifikasi Kampung KB',
                    'route' => null,
                ],
                #child klasifikasi
                #33
                [
                    'parent_id' => 32,
                    'title' => 'Klasifikasi Kampung KB',
                    'description' => 'Jumlah Kampung KB Menurut Klasifikasi',
                    'tooltip' => 'Jumlah Kampung KB Menurut Klasifikasi',
                    'route' => "portal.statistik.klasifikasi",
                ],

                #34
                [
                    'parent_id' => 1,
                    'title' => 'Kepemilikan Rencana Kerja',
                    'description' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Rencana Kerja',
                    'tooltip' => 'Jumlah Kampung KB Berdasarkan Kepemilikan Rencana Kerja',
                    'route' => "portal.statistik.kepemilikan-rkm",
                ],

                
            ],
            
        );
    }
}
