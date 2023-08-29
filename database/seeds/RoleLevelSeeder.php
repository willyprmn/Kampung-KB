<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = Role::find(1);
        $administrator->children()->attach([2, 3, 4, 5]);

        $pusat = Role::find(2);
        $pusat->children()->attach([3, 4, 5]);

        $provinsi = Role::find(3);
        $provinsi->children()->attach([4, 5]);

        $kabupaten = Role::find(4);
        $kabupaten->children()->attach(5);

    }
}
