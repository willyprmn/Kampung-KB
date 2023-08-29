<?php

namespace App\Observers;

use Cache;
use App\Models\ProgramGroup;

class ProgramGroupObserver
{
    /**
     * Handle the ProgramGroup "created" event.
     *
     * @param  \App\ProgramGroup  $ProgramGroup
     * @return void
     */
    public function created(ProgramGroup $ProgramGroup)
    {
        Cache::tags(get_class($ProgramGroup))->flush();
    }

    /**
     * Handle the ProgramGroup "updated" event.
     *
     * @param  \App\ProgramGroup  $ProgramGroup
     * @return void
     */
    public function updated(ProgramGroup $ProgramGroup)
    {
        Cache::tags(get_class($ProgramGroup))->flush();
    }

    /**
     * Handle the ProgramGroup "deleted" event.
     *
     * @param  \App\ProgramGroup  $ProgramGroup
     * @return void
     */
    public function deleted(ProgramGroup $ProgramGroup)
    {
        Cache::tags(get_class($ProgramGroup))->flush();
    }

    /**
     * Handle the ProgramGroup "restored" event.
     *
     * @param  \App\ProgramGroup  $ProgramGroup
     * @return void
     */
    public function restored(ProgramGroup $ProgramGroup)
    {
        //
    }

    /**
     * Handle the ProgramGroup "force deleted" event.
     *
     * @param  \App\ProgramGroup  $ProgramGroup
     * @return void
     */
    public function forceDeleted(ProgramGroup $ProgramGroup)
    {
        //
    }
}
