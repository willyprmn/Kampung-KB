<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\Contract\KampungRepository::class, \App\Repositories\Eloquent\KampungRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KriteriaRepository::class, \App\Repositories\Eloquent\KriteriaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\JenisPostRepository::class, \App\Repositories\Eloquent\JenisPostRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KategoriRepository::class, \App\Repositories\Eloquent\KategoriRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProgramRepository::class, \App\Repositories\Eloquent\ProgramRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\SasaranRepository::class, \App\Repositories\Eloquent\SasaranRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\IntervensiSasaranRepository::class, \App\Repositories\Eloquent\IntervensiSasaranRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InstansiRepository::class, \App\Repositories\Eloquent\InstansiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\IntervensiRepository::class, \App\Repositories\Eloquent\IntervensiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KkbpkRepository::class, \App\Repositories\Eloquent\KkbpkRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProfilRepository::class, \App\Repositories\Eloquent\ProfilRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\RegulasiRepository::class, \App\Repositories\Eloquent\RegulasiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\PlkbPengarahRepository::class, \App\Repositories\Eloquent\PlkbPengarahRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\OperasionalRepository::class, \App\Repositories\Eloquent\OperasionalRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProfilOperasionalRepository::class, \App\Repositories\Eloquent\ProfilOperasionalRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\FrekuensiRepository::class, \App\Repositories\Eloquent\FrekuensiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KontrasepsiRepository::class, \App\Repositories\Eloquent\KontrasepsiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KkbpkKontrasepsiRepository::class, \App\Repositories\Eloquent\KkbpkKontrasepsiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KkbpkProgramRepository::class, \App\Repositories\Eloquent\KkbpkProgramRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProfilSumberDanaRepository::class, \App\Repositories\Eloquent\ProfilSumberDanaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\SumberDanaRepository::class, \App\Repositories\Eloquent\SumberDanaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\PenggunaanDataRepository::class, \App\Repositories\Eloquent\PenggunaanDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProfilPenggunaanDataRepository::class, \App\Repositories\Eloquent\ProfilPenggunaanDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\RangeRepository::class, \App\Repositories\Eloquent\RangeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\PendudukRepository::class, \App\Repositories\Eloquent\PendudukRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KeluargaRepository::class, \App\Repositories\Eloquent\KeluargaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KkbpkNonKontrasepsiRepository::class, \App\Repositories\Eloquent\KkbpkNonKontrasepsiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\NonKontrasepsiRepository::class, \App\Repositories\Eloquent\NonKontrasepsiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProgramGroupRepository::class, \App\Repositories\Eloquent\ProgramGroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProvinsiRepository::class, \App\Repositories\Eloquent\ProvinsiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KabupatenRepository::class, \App\Repositories\Eloquent\KabupatenRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KecamatanRepository::class, \App\Repositories\Eloquent\KecamatanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\DesaRepository::class, \App\Repositories\Eloquent\DesaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\IntervensiGambarTypeRepository::class, \App\Repositories\Eloquent\IntervensiGambarTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\IntervensiGambarRepository::class, \App\Repositories\Eloquent\IntervensiGambarRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\IntervensiInstansiRepository::class, \App\Repositories\Eloquent\IntervensiInstansiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresRepository::class, \App\Repositories\Eloquent\InpresRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresSasaranRepository::class, \App\Repositories\Eloquent\InpresSasaranRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresProgramRepository::class, \App\Repositories\Eloquent\InpresProgramRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresKegiatanRepository::class, \App\Repositories\Eloquent\InpresKegiatanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresInstansiRepository::class, \App\Repositories\Eloquent\InpresInstansiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KeywordRepository::class, \App\Repositories\Eloquent\KeywordRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InstansiKeywordRepository::class, \App\Repositories\Eloquent\InstansiKeywordRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProfilRegulasiRepository::class, \App\Repositories\Eloquent\ProfilRegulasiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\PageRepository::class, \App\Repositories\Eloquent\PageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ConfigurationStatisticRepository::class, \App\Repositories\Eloquent\ConfigurationStatisticRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ProgramGroupDetailRepository::class, \App\Repositories\Eloquent\ProgramGroupDetailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\ArchiveRepository::class, \App\Repositories\Eloquent\ArchiveRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\MenuRepository::class, \App\Repositories\Eloquent\MenuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\RoleRepository::class, \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\UserRoleRepository::class, \App\Repositories\Eloquent\UserRoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\RoleMenuRepository::class, \App\Repositories\Eloquent\RoleMenuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\SigaRegionalRepository::class, \App\Repositories\Eloquent\SigaRegionalRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresKegiatanKeywordRepository::class, \App\Repositories\Eloquent\InpresKegiatanKeywordRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\KementerianRepository::class, \App\Repositories\Eloquent\KementerianRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresTargetRepository::class, \App\Repositories\Eloquent\InpresTargetRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\InpresIndikatorRepository::class, \App\Repositories\Eloquent\InpresIndikatorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contract\RoleLevelRepository::class, \App\Repositories\Eloquent\RoleLevelRepositoryEloquent::class);
        //:end-bindings:
    }
}
