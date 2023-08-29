<?php

namespace App\Observers;

use Cache;
use App\Models\InpresKegiatan;

class InpresKegiatanObserver
{
    /**
     * Handle the inpres kegiatan "created" event.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return void
     */
    public function created(InpresKegiatan $inpresKegiatan)
    {
        Cache::tags(get_class($inpresKegiatan))->flush();
    }

    /**
     * Handle the inpres kegiatan "updated" event.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return void
     */
    public function updated(InpresKegiatan $inpresKegiatan)
    {
        Cache::tags(get_class($inpresKegiatan))->flush();
    }

    /**
     * Handle the inpres kegiatan "deleted" event.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return void
     */
    public function deleted(InpresKegiatan $inpresKegiatan)
    {
        Cache::tags(get_class($inpresKegiatan))->flush();
    }

    /**
     * Handle the inpres kegiatan "restored" event.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return void
     */
    public function restored(InpresKegiatan $inpresKegiatan)
    {
        //
    }

    /**
     * Handle the inpres kegiatan "force deleted" event.
     *
     * @param  \App\Models\InpresKegiatan  $inpresKegiatan
     * @return void
     */
    public function forceDeleted(InpresKegiatan $inpresKegiatan)
    {
        //
    }
}
