<?php

namespace App\Observers;

use Cache;
use App\Models\Program;

class ProgramObserver
{
    /**
     * Handle the Program "created" event.
     *
     * @param  \App\Program  $Program
     * @return void
     */
    public function created(Program $Program)
    {
        Cache::tags(get_class($Program))->flush();
    }

    /**
     * Handle the Program "updated" event.
     *
     * @param  \App\Program  $Program
     * @return void
     */
    public function updated(Program $Program)
    {
        Cache::tags(get_class($Program))->flush();
    }

    /**
     * Handle the Program "deleted" event.
     *
     * @param  \App\Program  $Program
     * @return void
     */
    public function deleted(Program $Program)
    {
        Cache::tags(get_class($Program))->flush();
    }

    /**
     * Handle the Program "restored" event.
     *
     * @param  \App\Program  $Program
     * @return void
     */
    public function restored(Program $Program)
    {
        //
    }

    /**
     * Handle the Program "force deleted" event.
     *
     * @param  \App\Program  $Program
     * @return void
     */
    public function forceDeleted(Program $Program)
    {
        //
    }
}
