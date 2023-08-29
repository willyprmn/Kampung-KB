<?php

namespace App\Observers;

use Cache;
use App\Models\Intervensi;

class IntervensiObserver
{
    /**
     * Handle the intervensi "created" event.
     *
     * @param  \App\Models\Intervensi  $intervensi
     * @return void
     */
    public function created(Intervensi $intervensi)
    {
        Cache::tags(get_class($intervensi))->flush();
    }

    /**
     * Handle the intervensi "updated" event.
     *
     * @param  \App\Models\Intervensi  $intervensi
     * @return void
     */
    public function updated(Intervensi $intervensi)
    {
        Cache::tags(get_class($intervensi))->flush();
    }

    /**
     * Handle the intervensi "deleted" event.
     *
     * @param  \App\Models\Intervensi  $intervensi
     * @return void
     */
    public function deleted(Intervensi $intervensi)
    {
        Cache::tags(get_class($intervensi))->flush();
    }

    /**
     * Handle the intervensi "restored" event.
     *
     * @param  \App\Models\Intervensi  $intervensi
     * @return void
     */
    public function restored(Intervensi $intervensi)
    {
        //
    }

    /**
     * Handle the intervensi "force deleted" event.
     *
     * @param  \App\Models\Intervensi  $intervensi
     * @return void
     */
    public function forceDeleted(Intervensi $intervensi)
    {
        //
    }
}
