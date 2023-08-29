<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        activity()->disableLogging();
        # start-seeding

        try {

            DB::beginTransaction();

            ################### after mapping image ###################

            $this->call(UserPhoneSeeder::class);
            $this->call(FrekuensiOrderSeeder::class);
            $this->call(MenuRekapitulasiSeeder::class);
            $this->call(KampungUpdateSeeder::class);
            $this->call(RoleLevelSeeder::class);
            $this->call(ConfigurationStatisticSeeder::class);

            # update missing regional
            $this->call(KampungUpdateMergerSeeder::class);
            $this->call(UpdateRumahDataProgramSeeder::class);
            $this->call(UpdateTitlePesertaPoktanStatisticSeeder::class);

            # update value for adjustment balance total betwen PUS and Kontrasepsi & Non Kontrasepsi
            $this->call(KampungCleansingUnmetNeedSeeder::class);

            # update value for adjustment balance total betwen PENDUDUK and KKBPK
            $this->call(KampungCleansingPendudukKkbpkSeeder::class);

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();
            $this->command->error($e->getMessage());
        }

        # end-seeding
        activity()->enableLogging();
    }
}
