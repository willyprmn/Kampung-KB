<?php

namespace App\Repositories\Criteria\Program;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Program as ProgramModel;
/**
 * Class AccumulatedKkbpkCriteria.
 *
 * @package namespace App\Repositories\Criteria\Program;
 */
class AccumulatedKkbpkCriteria implements CriteriaInterface
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

        $table = ProgramModel::getTableName();
        return $model
            ->select([
                "$table.id",
                "$table.name",
                "$table.deskripsi"
            ])
            ->whereHas('groups', function ($group) {
                return $group->where('name', 'Poktan');
            })
            ->where('id','<>', 6) #exclude sekretariat
            ->withCount(['profils' => function ($profil) {
                return $profil
                    ->where('new_profil_program.program_flag', true)
                    ->where('is_active', true)
                    ->whereHas('kampung', function($kampung){
                        return $kampung->where('is_active', true);
                    })
                    ;
            }])
            ;
    }
}
