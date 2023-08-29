<?php

namespace App\Observers;

use Cache;
use App\Models\InpresSasaran;

class InpresSasaranObserver
{
    /**
     * Handle the inpres sasaran "created" event.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return void
     */
    public function created(InpresSasaran $inpresSasaran)
    {
        Cache::tags(get_class($inpresSasaran))->flush();
    }

    /**
     * Handle the inpres sasaran "updated" event.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return void
     */
    public function updated(InpresSasaran $inpresSasaran)
    {
        Cache::tags(get_class($inpresSasaran))->flush();
    }

    /**
     * Handle the inpres sasaran "deleted" event.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return void
     */
    public function deleted(InpresSasaran $inpresSasaran)
    {
        Cache::tags(get_class($inpresSasaran))->flush();
    }

    /**
     * Handle the inpres sasaran "restored" event.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return void
     */
    public function restored(InpresSasaran $inpresSasaran)
    {
        //
    }

    /**
     * Handle the inpres sasaran "force deleted" event.
     *
     * @param  \App\Models\InpresSasaran  $inpresSasaran
     * @return void
     */
    public function forceDeleted(InpresSasaran $inpresSasaran)
    {
        //
    }
}
