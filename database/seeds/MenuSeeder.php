<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::truncate();
        $managementUser = Menu::create([
            'name' => null,
            'label' => 'Management User',
            'order' => 1,
            'icon' => 'users',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = new Menu([
            'name' => 'admin.user.index',
            'label' => 'User',
            'order' => 1.1,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $managementUser->children()->save($user);
        $user->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 1.101,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 1.11,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 1.12,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 1.13,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 1.14,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reset',
                'label' => 'Reset password',
                'order' => 1.15,
                'icon' => 'warning',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $groupSetting = new Menu([
            'name' => 'admin.role.index',
            'label' => 'Hak Akses',
            'order' => 1.2,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $managementUser->children()->save($groupSetting);
        $groupSetting->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 1.201,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 1.21,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 1.22,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 1.23,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 1.24,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $master = Menu::create([
            'name' => null,
            'label' => 'Master Data',
            'order' => 2,
            'icon' => 'copy',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $keyword = new Menu([
            'name' => 'admin.keyword.index',
            'label' => 'Keyword',
            'order' => 2.1,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $master->children()->save($keyword);
        $keyword->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.101,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Keyword',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.11,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Keyword',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.12,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Keyword',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.13,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Keyword',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.14,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Keyword',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        $instansi = new Menu([
            'name' => 'admin.instansi.index',
            'label' => 'Instansi',
            'order' => 2.2,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $master->children()->save($instansi);
        $instansi->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.201,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.21,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.22,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.23,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.24,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Instansi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $program = new Menu([
            'name' => 'admin.program.index',
            'label' => 'Program',
            'order' => 2.3,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $master->children()->save($program);
        $program->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.301,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Program',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.31,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Program',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.32,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Program',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.33,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Program',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.34,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Program',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $groupProgram = new Menu([
            'name' => 'admin.program-group.index',
            'label' => 'Group Program',
            'order' => 2.4,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $master->children()->save($groupProgram);
        $groupProgram->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.401,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProgramGroup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.41,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProgramGroup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.42,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProgramGroup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.43,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProgramGroup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.44,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProgramGroup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $manajemenInpres = Menu::create([
            'name' => null,
            'label' => 'Manajemen Inpres',
            'order' => 2.5,
            'icon' => 'gavel',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $inpresSasaran = new Menu([
            'name' => 'admin.inpres-sasaran.index',
            'label' => 'Sasaran',
            'order' => 2.51,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $manajemenInpres->children()->save($inpresSasaran);
        $inpresSasaran->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.511,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresSasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.512,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresSasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.513,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresSasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.514,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresSasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.515,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresSasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        $inpresProgram = new Menu([
            'name' => 'admin.inpres-program.index',
            'label' => 'Program',
            'order' => 2.52,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $manajemenInpres->children()->save($inpresProgram);
        $inpresProgram->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.521,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresProgram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.522,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresProgram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.523,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresProgram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.524,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresProgram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.525,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresProgram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        $inpresKegiatan = new Menu([
            'name' => 'admin.inpres-kegiatan.index',
            'label' => 'Kegiatan',
            'order' => 2.53,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $manajemenInpres->children()->save($inpresKegiatan);
        $inpresKegiatan->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 2.531,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresKegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 2.532,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresKegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 2.533,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresKegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 2.534,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresKegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 2.535,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\InpresKegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);



        $managementKampung = Menu::create([
            'name' => null,
            'label' => 'Manajemen Kampung',
            'order' => 3,
            'icon' => 'chart-pie',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $kampung = new Menu([
            'name' => 'admin.kampungs.index',
            'label' => 'Kampung KB',
            'order' => 3.1,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($kampung);
        $kampung->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 3.101,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 3.11,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 3.12,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 3.13,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 3.14,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $profil = new Menu([
            'label' => 'Profil Kampung KB',
            'order' => 3.15,
            'icon' => 'circle',
            'is_menu' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($profil);
        $profil->children()->createMany([
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 3.151,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProfilKampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 3.152,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\ProfilKampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $penduduk = new Menu([
            'label' => 'Profil Kependudukan',
            'order' => 3.16,
            'icon' => 'circle',
            'is_menu' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($penduduk);
        $penduduk->children()->createMany([
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 3.161,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\PendudukKampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 3.162,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\PendudukKampung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $kkbpk = new Menu([
            'label' => 'Program KKBPK',
            'order' => 3.17,
            'icon' => 'circle',
            'is_menu' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($kkbpk);
        $kkbpk->children()->createMany([
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 3.171,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kkbpk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 3.172,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Kkbpk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $intervensi = new Menu([
            'label' => 'Intervensi',
            'order' => 3.18,
            'icon' => 'circle',
            'is_menu' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($intervensi);
        $intervensi->children()->createMany([
            [
                'name' => 'view',
                'label' => 'Detail',
                'order' => 3.181,
                'icon' => 'info',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Intervensi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create',
                'label' => 'Tambah',
                'order' => 3.182,
                'icon' => 'primary',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Intervensi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 3.183,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Intervensi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete',
                'label' => 'Hapus',
                'order' => 3.184,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'App\\Models\\Intervensi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        $percontohan = new Menu([
            'name' => 'admin.percontohan.index',
            'label' => 'Percontohan',
            'order' => 3.2,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($percontohan);
        $percontohan->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 3.201,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'Percontohan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Percontohan Kabupaten',
                'order' => 3.21,
                'icon' => 'warning',
                'is_menu' => false,
                'policy_of' => 'Percontohan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Batal Kabupaten',
                'order' => 3.22,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'Percontohan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Percontohan Provinsi',
                'order' => 3.23,
                'icon' => 'warning',
                'is_menu' => false,
                'policy_of' => 'Percontohan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update',
                'label' => 'Batal Provinsi',
                'order' => 3.24,
                'icon' => 'danger',
                'is_menu' => false,
                'policy_of' => 'Percontohan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $progress = new Menu([
            'name' => 'admin.progres-statistik.index',
            'label' => 'Progres Statisik',
            'order' => 3.3,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $managementKampung->children()->save($progress);
        $progress->children()->createMany([
            [
                'name' => 'viewAny',
                'label' => 'Indeks',
                'order' => 3.31,
                'icon' => 'secondary',
                'is_menu' => false,
                'policy_of' => 'ProgressStatistik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $konfigurasi = Menu::create([
            'label' => 'Konfigurasi',
            'order' => 4.0,
            'icon' => 'cogs',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tentang = new Menu([
            'name' => 'admin.page.about',
            'label' => 'Tentang',
            'order' => 4.1,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $konfigurasi->children()->save($tentang);
        $tentang->children()->createMany([
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 4.11,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'PageAbout',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        $header = new Menu([
            'name' => 'admin.page.header',
            'label' => "Header",
            'order' => 4.2,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $konfigurasi->children()->save($header);
        $header->children()->createMany([
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 4.21,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'PageHeader',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $tooltip = new Menu([
            'name' => 'admin.configuration.tooltip-statistik',
            'label' => "Tooltip Statistik",
            'order' => 4.3,
            'icon' => 'circle',
            'is_menu' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $konfigurasi->children()->save($tooltip);
        $tooltip->children()->createMany([
            [
                'name' => 'update',
                'label' => 'Update',
                'order' => 4.31,
                'icon' => 'success',
                'is_menu' => false,
                'policy_of' => 'Tooltip',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}