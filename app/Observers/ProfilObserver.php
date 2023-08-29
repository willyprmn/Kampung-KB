<?php

namespace App\Observers;

use Cache;
use App\Models\ProfilKampung;

class ProfilObserver
{
    /**
     * Handle the profil kampung "created" event.
     *
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return void
     */
    public function created(ProfilKampung $profilKampung)
    {
        Cache::tags(get_class($profilKampung))->flush();
    }

    /**
     * Handle the profil kampung "updated" event.
     *
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return void
     */
    public function updated(ProfilKampung $profilKampung)
    {
        Cache::tags(get_class($profilKampung))->flush();
    }

    /**
     * Handle the profil kampung "deleted" event.
     *
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return void
     */
    public function deleted(ProfilKampung $profilKampung)
    {
        Cache::tags(get_class($profilKampung))->flush();
    }

    /**
     * Handle the profil kampung "restored" event.
     *
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return void
     */
    public function restored(ProfilKampung $profilKampung)
    {
        //
    }

    /**
     * Handle the profil kampung "force deleted" event.
     *
     * @param  \App\Models\ProfilKampung  $profilKampung
     * @return void
     */
    public function forceDeleted(ProfilKampung $profilKampung)
    {
        //
    }
}
