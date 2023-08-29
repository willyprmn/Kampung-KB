<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Menu;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::truncate();

        #1
        $admin = Role::create([
            'name' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $menus = Menu::get()->pluck('id');
        $admin->menus()->attach($menus);

        #2
        $pusat = Role::create([
            'name' => 'Admin Pusat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $menus = Menu::get()->pluck('id');
        $pusat->menus()->attach($menus);

        #3
        $provinsi = Role::create([
            'name' => 'Admin Provinsi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permitUser = Menu::whereBetween('order', [1.101, 1.14])->get()->pluck('id');
        $permitKampung = Menu::whereBetween('order', [3.101, 3.14])->where('is_menu', false)->get()->pluck('id');
        $permitPercontohan  = Menu::whereBetween('order', [3.201, 3.24])->where('is_menu', false)->get()->pluck('id');
        $provinsi->menus()->attach(
            $permitUser
                ->merge($permitKampung)
                ->merge($permitPercontohan)
        );

        #4
        $kabupaten = Role::create([
            'name' => 'Admin Kabupaten',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $kabupaten->menus()->attach($permitUser->merge($permitKampung));

        // $kecamatan = Role::create([
        //     'name' => 'Admin Kecamatan',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $kecamatan->menus()->attach($permitUser->merge($permitKampung));

        // $desa = Role::create([
        //     'name' => 'Desa/Pengisi Konten',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // $desa->menus()->attach($permitKampung); #only kampung

        #5
        $writer = Role::create([
            'name' => 'Desa/Pengisi Konten',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $permitReport = Menu::whereBetween('order', [3, 3.184])->get()->pluck('id');
        $writer->menus()->attach($permitReport);
    }
}
