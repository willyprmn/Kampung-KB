<?php

namespace App\Observers;

use Cache;
use App\Models\Kkbpk;

class KkbpkObserver
{
    /**
     * Handle the kkbpk kampung "created" event.
     *
     * @param  \App\Models\KkbpkKampung  $kkbpkKampung
     * @return void
     */
    public function created(Kkbpk $kkbpk)
    {
        Cache::tags(get_class($kkbpk))->flush();
    }

    /**
     * Handle the kkbpk kampung "updated" event.
     *
     * @param  \App\Models\KkbpkKampung  $kkbpkKampung
     * @return void
     */
    public function updated(Kkbpk $kkbpk)
    {
        Cache::tags(get_class($kkbpk))->flush();
    }

    /**
     * Handle the kkbpk kampung "deleted" event.
     *
     * @param  \App\Models\KkbpkKampung  $kkbpkKampung
     * @return void
     */
    public function deleted(Kkbpk $kkbpk)
    {
        Cache::tags(get_class($kkbpk))->flush();
    }

    /**
     * Handle the kkbpk kampung "restored" event.
     *
     * @param  \App\Models\KkbpkKampung  $kkbpkKampung
     * @return void
     */
    public function restored(Kkbpk $kkbpk)
    {
        //
    }

    /**
     * Handle the kkbpk kampung "force deleted" event.
     *
     * @param  \App\Models\KkbpkKampung  $kkbpkKampung
     * @return void
     */
    public function forceDeleted(Kkbpk $kkbpk)
    {
        //
    }
}
