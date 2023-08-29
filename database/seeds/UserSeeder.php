<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        User::truncate();
        $admin = User::create([
            'email' => 'admin@bkkbn.go.id',
            'password' => Hash::make('password'),
            'siga_id' => Hash::make(time()),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::unprepared(file_get_contents(database_path('sql/seeder/21-user.sql')));

        User::where('email', '<>', null)->update([
            'password' => Hash::make('password'),
        ]);

    }
}
