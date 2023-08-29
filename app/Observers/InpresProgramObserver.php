<?php

namespace App\Observers;

use Cache;
use App\Models\InpresProgram;

class InpresProgramObserver
{
    /**
     * Handle the inpres program "created" event.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return void
     */
    public function created(InpresProgram $inpresProgram)
    {
        Cache::tags(get_class($inpresProgram))->flush();
    }

    /**
     * Handle the inpres program "updated" event.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return void
     */
    public function updated(InpresProgram $inpresProgram)
    {
        Cache::tags(get_class($inpresProgram))->flush();
    }

    /**
     * Handle the inpres program "deleted" event.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return void
     */
    public function deleted(InpresProgram $inpresProgram)
    {
        Cache::tags(get_class($inpresProgram))->flush();
    }

    /**
     * Handle the inpres program "restored" event.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return void
     */
    public function restored(InpresProgram $inpresProgram)
    {
        //
    }

    /**
     * Handle the inpres program "force deleted" event.
     *
     * @param  \App\Models\InpresProgram  $inpresProgram
     * @return void
     */
    public function forceDeleted(InpresProgram $inpresProgram)
    {
        //
    }
}
