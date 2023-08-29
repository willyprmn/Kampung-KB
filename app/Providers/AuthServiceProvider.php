<?php

namespace App\Providers;

use Auth;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\InpresKegiatan::class => \App\Policies\InpresKegiatanPolicy::class,
        \App\Models\InpresProgram::class => \App\Policies\InpresProgramPolicy::class,
        \App\Models\InpresSasaran::class => \App\Policies\InpresSasaranPolicy::class,
        \App\Models\Instansi::class => \App\Policies\InstansiPolicy::class,
        \App\Models\Intervensi::class => \App\Policies\IntervensiPolicy::class,
        \App\Models\Kampung::class => \App\Policies\KampungPolicy::class,
        \App\Models\Keyword::class => \App\Policies\KeywordPolicy::class,
        \App\Models\Kkbpk::class => \App\Policies\KkbpkPolicy::class,
        \App\Models\Menu::class => \App\Policies\MenuPolicy::class,
        \App\Models\PendudukKampung::class => \App\Policies\PendudukPolicy::class,
        \App\Models\ProfilKampung::class => \App\Policies\ProfilPolicy::class,
        \App\Models\ProgramGroup::class => \App\Policies\ProgramGroupPolicy::class,
        \App\Models\Program::class => \App\Policies\ProgramPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    protected $hash;

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(HasherContract $hash)
    {

        $this->hash = $hash;

        $this->registerPolicies();

        Auth::provider('eloquent', function ($app, array $config) {
            return new \App\Services\Auth\EloquentUserProvider($this->hash, $config['model']);
        });

        Gate::define('any-percontohan', function (User $user) {

            switch (true) {
                case session()
                    ->get('permissions')
                    ->where('policy_of', 'Percontohan')
                    ->where('name', 'viewAny')
                    ->isEmpty():
                    return Response::deny('Anda tidak berhak mengakses halaman ini.');
                default:
                    return Response::allow();
            }
        });

        #keyword
        Gate::define('keyword-create', function (User $user) {
            switch (true) {
                case session()
                    ->get('permissions')
                    ->where('policy_of', 'App\Models\Keyword')
                    ->where('name', 'create')
                    ->isEmpty():
                    return false;
                default:
                    return true;
            }
        });

        Gate::define('keyword-update', function (User $user) {
            switch (true) {
                case session()
                    ->get('permissions')
                    ->where('policy_of', 'App\Models\Keyword')
                    ->where('name', 'update')
                    ->isEmpty():
                    return false;
                default:
                    return true;
            }
        });

        Gate::define('keyword-delete', function (User $user) {
            switch (true) {
                case session()
                    ->get('permissions')
                    ->where('policy_of', 'App\Models\Keyword')
                    ->where('name', 'delete')
                    ->isEmpty():
                    return false;
                default:
                    return true;
            }
        });


    }
}
