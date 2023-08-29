<?php

namespace App\Repositories\Criteria\Program;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\InpresProgram as InpresProgramModel;
use DB;
/**
 * Class AccumulatedKkbpkCriteria.
 *
 * @package namespace App\Repositories\Criteria\Program;
 */
class InpresCriteria implements CriteriaInterface
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

        $table = InpresProgramModel::getTableName();
        return $model
            ->select([
                "$table.id",
                "$table.name",
                DB::raw("case when id = 1 then 'Data dan Dokumen Kependudukan' 
                    when id = 2 then 'Komunikasi Perubahan Perilaku'
                    when id = 3 then 'Layanan Kesehatan dan KB-KR'
                    when id = 4 then 'Pendampingan & Layanan Stunting'
                    when id = 5 then 'Akses Pendidikan'
                    when id = 6 then 'Jaminan dan Perlindungan Sosial'
                    when id = 7 then 'Pemberdayaan ekonomi'
                    when id = 8 then 'Penataan Lingkugan'
                end alias")
            ])
            ->withCount(['intervensis' => function ($intervensi) {
                $intervensi
                    ->select(DB::raw('count(distinct(kampung_kb_id, inpres_kegiatan_id))'))
                    ->whereHas('kampung', function ($kampung) {
                        $kampung->active();
                    });
            }])
            ;
    }
}
