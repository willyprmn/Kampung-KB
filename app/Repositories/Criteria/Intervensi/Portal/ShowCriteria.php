<?php

namespace App\Repositories\Criteria\Intervensi\Portal;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShowCriteria.
 *
 * @package namespace App\Repositories\Criteria\Intervensi\Portal;
 */
class ShowCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $table = \App\Models\Intervensi::getTableName();
        return $model
            ->select([
                "{$table}.id",
                "{$table}.judul",
                "{$table}.inpres_kegiatan_id",
                "{$table}.tanggal",
                "{$table}.kampung_kb_id",
                "{$table}.program_id",
                "{$table}.kategori_id",
                "{$table}.deskripsi",
            ])
            ->whereHas('kampung')
            ->with(['intervensi_gambar' => function ($gambar) {
                $gambarTable = \App\Models\IntervensiGambar::getTableName();
                return $gambar->select([
                    "{$gambarTable}.id",
                    "{$gambarTable}.path",
                    "{$gambarTable}.intervensi_id",
                ]);
            }])
            ->with(['inpres_kegiatan' => function ($inpresKegiatan) {
                $inpresKegiatanTable = \App\Models\InpresKegiatan::getTableName();
                return $inpresKegiatan->select([
                    "{$inpresKegiatanTable}.id",
                    "{$inpresKegiatanTable}.name"
                ]);
            }])
            ->with(['kampung' => function ($kampung) {
                $kampungTable = \App\Models\Kampung::getTableName();
                return $kampung->select([
                    "{$kampungTable}.id",
                    "{$kampungTable}.nama",
                ]);
            }])
            ->with(['program', 'kategori', 'instansis', 'sasarans'])
            ;
    }
}