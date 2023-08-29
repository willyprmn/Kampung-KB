<?php

namespace App\Console\Commands;

use Cache;
use DB;
use Log;

use Illuminate\Console\Command;

class MigrationReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove conflict migration with prefixed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if (config('app.env') === 'production') {
            return Log::error('THIS DANGEROUS COMMAND CANNOT BE EXECUTED ON PRODUCTION...!!!');
        }

        try {

            if ($this->confirm('Do you wish to continue?')) {

                DB::beginTransaction();

                DB::unprepared(file_get_contents(database_path('sql/command/migration-reset.sql')));

                DB::commit();

                $this->info('All new table has been reset.');

            } else {

                $this->info('Command aborted.');
            }

        } catch (\Exception $e) {

            DB::rollback();
            $this->error('Something error. Please rever to laravel.log to see more detail.');
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
        }

    }
}
