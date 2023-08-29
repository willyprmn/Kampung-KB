<?php

namespace App\Services;

use App\Repositories\Criteria\Kampung\WilayahCriteria as KampungWilayahCriteria;
use App\Repositories\Contract\KampungRepository;
use App\Models\Archive as ArchiveModel;
use App\Models\Kampung;
use App\Models\Intervensi;

class KampungService
{

    protected $repository;

    public function __construct(KampungRepository $repository)
    {
        $this->repository = $repository;
    }


    public function generateKampungPath(Kampung $kampung, $suffix = '')
    {

        $provinsi = $kampung->provinsi_id;
        $kabupaten = $kampung->kabupaten_id;
        $kecamatan = $kampung->kecamatan_id;
        $desa = $kampung->desa_id;
        $id = $kampung->id;

        $directory = $suffix . DIRECTORY_SEPARATOR .
            $provinsi . DIRECTORY_SEPARATOR .
            $kabupaten . DIRECTORY_SEPARATOR .
            $kecamatan . DIRECTORY_SEPARATOR .
            $desa . DIRECTORY_SEPARATOR .
            $id . DIRECTORY_SEPARATOR
            ;

        return $directory;
    }


    public function generateIntervensiPath(Intervensi $intervensi, $prefix = 'intervensi')
    {
        $time = strtotime($intervensi->created_at);
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        return $prefix . DIRECTORY_SEPARATOR .
            $year . DIRECTORY_SEPARATOR .
            $month . DIRECTORY_SEPARATOR .
            $day . DIRECTORY_SEPARATOR .
            $intervensi->id . DIRECTORY_SEPARATOR
            ;
    }


    public function uploadRkm(int $id, $rkm = null): ?ArchiveModel
    {

        $this->repository->skipCache();

        if (is_null($rkm)) {
            $kampung = $this->repository
                ->with(['profils' => function ($query) {
                    $query->with('archive')
                        ->has('archive')
                        ->orderBy('id', 'DESC')
                        ->take(1)
                        ;
                }])
                ->find($id);

            # Return last archive or not at all
            return $kampung->profils->first()->archive ?? null;
        }

        $this->repository->pushCriteria(KampungWilayahCriteria::class);
        $kampung = $this->repository->find($id);

        $provinsi = $kampung->provinsi->name;
        $kabupaten = $kampung->kabupaten->name;
        $kecamatan = $kampung->kecamatan->name;
        $kampungName = trim($kampung->nama);
        $today = now()->format('Y-m-d');
        $directory = 'laporan' . DIRECTORY_SEPARATOR .
            $provinsi . DIRECTORY_SEPARATOR .
            $kabupaten . DIRECTORY_SEPARATOR .
            $kecamatan . DIRECTORY_SEPARATOR .
            $kampungName . DIRECTORY_SEPARATOR .
            'Profil'
            ;

        $archive = new ArchiveModel();
        $archive->name = $rkm->getClientOriginalName();
        $archive->path = $directory . DIRECTORY_SEPARATOR . $rkm->getClientOriginalName();
        $archive->ext = $rkm->extension();

        $archive->path = $rkm->storeAs(
            $directory,
            $archive->name
        );

        return $archive;
    }
}