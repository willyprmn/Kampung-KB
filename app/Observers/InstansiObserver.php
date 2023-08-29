<?php

namespace App\Observers;

use Cache;
use App\Models\Instansi;

class InstansiObserver
{
    /**
     * Handle the instansi "created" event.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return void
     */
    public function created(Instansi $instansi)
    {
        Cache::tags(get_class($instansi))->flush();
    }

    /**
     * Handle the instansi "updated" event.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return void
     */
    public function updated(Instansi $instansi)
    {
        Cache::tags(get_class($instansi))->flush();
    }

    /**
     * Handle the instansi "deleted" event.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return void
     */
    public function deleted(Instansi $instansi)
    {
        Cache::tags(get_class($instansi))->flush();
    }

    /**
     * Handle the instansi "restored" event.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return void
     */
    public function restored(Instansi $instansi)
    {
        //
    }

    /**
     * Handle the instansi "force deleted" event.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return void
     */
    public function forceDeleted(Instansi $instansi)
    {
        //
    }
}
