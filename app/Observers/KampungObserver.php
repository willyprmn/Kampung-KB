<?php

namespace App\Observers;

use Cache;
use App\Models\Kampung;

class KampungObserver
{
    /**
     * Handle the kampung "created" event.
     *
     * @param  \App\Models\Kampung  $kampung
     * @return void
     */
    public function created(Kampung $kampung)
    {
        Cache::tags(get_class($kampung))->flush();
    }

    /**
     * Handle the kampung "updated" event.
     *
     * @param  \App\Models\Kampung  $kampung
     * @return void
     */
    public function updated(Kampung $kampung)
    {
        Cache::tags(get_class($kampung))->flush();
    }

    /**
     * Handle the kampung "deleted" event.
     *
     * @param  \App\Models\Kampung  $kampung
     * @return void
     */
    public function deleted(Kampung $kampung)
    {
        Cache::tags(get_class($kampung))->flush();
    }

    /**
     * Handle the kampung "restored" event.
     *
     * @param  \App\Models\Kampung  $kampung
     * @return void
     */
    public function restored(Kampung $kampung)
    {
        //
    }

    /**
     * Handle the kampung "force deleted" event.
     *
     * @param  \App\Models\Kampung  $kampung
     * @return void
     */
    public function forceDeleted(Kampung $kampung)
    {
        Cache::tags(get_class($kampung))->flush();
    }
}
