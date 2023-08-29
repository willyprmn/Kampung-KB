<?php

namespace App\Observers;

use Cache;
use App\Models\Keyword;

class KeywordObserver
{
    /**
     * Handle the keyword "created" event.
     *
     * @param  \App\Keyword  $keyword
     * @return void
     */
    public function created(Keyword $keyword)
    {
        Cache::tags(get_class($keyword))->flush();
    }

    /**
     * Handle the keyword "updated" event.
     *
     * @param  \App\Keyword  $keyword
     * @return void
     */
    public function updated(Keyword $keyword)
    {
        Cache::tags(get_class($keyword))->flush();
    }

    /**
     * Handle the keyword "deleted" event.
     *
     * @param  \App\Keyword  $keyword
     * @return void
     */
    public function deleted(Keyword $keyword)
    {
        Cache::tags(get_class($keyword))->flush();
    }

    /**
     * Handle the keyword "restored" event.
     *
     * @param  \App\Keyword  $keyword
     * @return void
     */
    public function restored(Keyword $keyword)
    {
        //
    }

    /**
     * Handle the keyword "force deleted" event.
     *
     * @param  \App\Keyword  $keyword
     * @return void
     */
    public function forceDeleted(Keyword $keyword)
    {
        //
    }
}
