<?php

namespace App\Observers;

use Cache;
use App\Models\PendudukKampung;

class PendudukObserver
{
    /**
     * Handle the penduduk kampung "created" event.
     *
     * @param  \App\Models\PendudukKampung  $pendudukKampung
     * @return void
     */
    public function created(PendudukKampung $pendudukKampung)
    {
        Cache::tags(get_class($pendudukKampung))->flush();
    }

    /**
     * Handle the penduduk kampung "updated" event.
     *
     * @param  \App\Models\PendudukKampung  $pendudukKampung
     * @return void
     */
    public function updated(PendudukKampung $pendudukKampung)
    {
        Cache::tags(get_class($pendudukKampung))->flush();
    }

    /**
     * Handle the penduduk kampung "deleted" event.
     *
     * @param  \App\Models\PendudukKampung  $pendudukKampung
     * @return void
     */
    public function deleted(PendudukKampung $pendudukKampung)
    {
        Cache::tags(get_class($pendudukKampung))->flush();
    }

    /**
     * Handle the penduduk kampung "restored" event.
     *
     * @param  \App\Models\PendudukKampung  $pendudukKampung
     * @return void
     */
    public function restored(PendudukKampung $pendudukKampung)
    {
        //
    }

    /**
     * Handle the penduduk kampung "force deleted" event.
     *
     * @param  \App\Models\PendudukKampung  $pendudukKampung
     * @return void
     */
    public function forceDeleted(PendudukKampung $pendudukKampung)
    {
        //
    }
}
