<?php

namespace App\Repositories\Criteria\Kampung;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WilayahCriteria.
 *
 * @package namespace App\Repositories\Criteria\Kampung;
 */
class WilayahCriteria implements CriteriaInterface
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

        $table = \App\Models\Kampung::getTableName();
        return $model
            ->select([
                "{$table}.id",
                "{$table}.nama",
                "{$table}.provinsi_id",
                "{$table}.kabupaten_id",
                "{$table}.kecamatan_id",
                "{$table}.desa_id",
                "{$table}.path_gambar",
                "{$table}.tanggal_pencanangan"
            ])
            ->with([
                'provinsi:id,name',
                'kabupaten:id,name',
                'kecamatan:id,name',
            ]);
    }
}
