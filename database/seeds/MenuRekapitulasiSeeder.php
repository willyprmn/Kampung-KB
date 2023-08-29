<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuRekapitulasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        #menu rekap
        $rekapitulasi = Menu::create([
            'name' => null,
            'label' => 'Rekapitulasi',
            'order' => 5,
            'icon' => 'chart-pie',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        #rekap konten
        $pengisiKonten = new Menu([
            'name' => 'admin.rekap-pengisi-konten.index',
            'label' => 'Pengisi Konten',
            'order' => 5.1,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rekapitulasi->children()->save($pengisiKonten);
        $pengisiKonten->children()->createMany([
            [
                'name' => 'viewRekapKonten',
                'label' => 'Indeks',
                'order' => 5.101,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'downloadRekapKonten',
                'label' => 'Download',
                'order' => 5.11,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        #rekap admin provinsi
        $adminProvinsi = new Menu([
            'name' => 'admin.rekap-admin-provinsi.index',
            'label' => 'Admin Provinsi',
            'order' => 5.2,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rekapitulasi->children()->save($adminProvinsi);
        $adminProvinsi->children()->createMany([
            [
                'name' => 'viewRekapProvinsi',
                'label' => 'Indeks',
                'order' => 5.201,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'downloadRekapProvinsi',
                'label' => 'Download',
                'order' => 5.21,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        #rekap admin kabupaten
        $adminKabupaten = new Menu([
            'name' => 'admin.rekap-admin-kabupaten.index',
            'label' => 'Admin Kabupaten',
            'order' => 5.3,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rekapitulasi->children()->save($adminKabupaten);
        $adminKabupaten->children()->createMany([
            [
                'name' => 'viewRekapKabupaten',
                'label' => 'Indeks',
                'order' => 5.301,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'downloadRekapKabupaten',
                'label' => 'Download',
                'order' => 5.31,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        #rekap klasifikasi
        $adminKabupaten = new Menu([
            'name' => 'admin.rekap-klasifikasi.index',
            'label' => 'Klasifikasi',
            'order' => 5.4,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rekapitulasi->children()->save($adminKabupaten);
        $adminKabupaten->children()->createMany([
            [
                'name' => 'viewRekapKlasifikasi',
                'label' => 'Indeks',
                'order' => 5.401,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'downloadRekapKlasifikasi',
                'label' => 'Download',
                'order' => 5.402,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        #rekap kampung detail
        $adminKabupaten = new Menu([
            'name' => 'admin.rekap-kampung.index',
            'label' => 'Kampung',
            'order' => 5.5,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rekapitulasi->children()->save($adminKabupaten);
        $adminKabupaten->children()->createMany([
            [
                'name' => 'viewRekapKampung',
                'label' => 'Indeks',
                'order' => 5.501,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'downloadRekapKampung',
                'label' => 'Download',
                'order' => 5.502,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
