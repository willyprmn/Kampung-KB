<?php

namespace App\Providers;

use App\Models\{
    InpresKegiatan,
    InpresProgram,
    InpresSasaran,
    Instansi,
    Intervensi,
    Kampung,
    Keyword,
    Kkbpk,
    PendudukKampung,
    ProfilKampung,
    User,
    Program,
    ProgramGroup,
    Role,
};
use App\Observers\{
    InpresKegiatanObserver,
    InpresProgramObserver,
    InpresSasaranObserver,
    InstansiObserver,
    IntervensiObserver,
    KampungObserver,
    KeywordObserver,
    KkbpkObserver,
    PendudukObserver,
    ProfilObserver,
    UserObserver,
    ProgramObserver,
    ProgramGroupObserver,
    RoleObserver
};
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        InpresKegiatan::observe(InpresKegiatanObserver::class);
        InpresProgram::observe(InpresProgramObserver::class);
        InpresSasaran::observe(InpresSasaranObserver::class);
        Instansi::observe(InstansiObserver::class);
        Intervensi::observe(IntervensiObserver::class);
        Kampung::observe(KampungObserver::class);
        Keyword::observe(KeywordObserver::class);
        Kkbpk::observe(KkbpkObserver::class);
        PendudukKampung::observe(PendudukObserver::class);
        ProfilKampung::observe(ProfilObserver::class);
        User::observe(UserObserver::class);
        Program::observe(ProgramObserver::class);
        ProgramGroup::observe(ProgramGroupObserver::class);
        Role::observe(RoleObserver::class);
    }
}
